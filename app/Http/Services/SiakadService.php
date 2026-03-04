<?php

namespace App\Http\Services;

use App\Exceptions\SiakadException;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class SiakadService
{
    private readonly CookieJar $jar;

    private readonly Client $client;

    public string $siakadUrl;

    private array $container = [];

    public function __construct(string $siakadUrl)
    {
        $this->jar = new CookieJar;
        $this->siakadUrl = $siakadUrl;

        $history = Middleware::history($this->container);
        $handlerStack = HandlerStack::create();
        $handlerStack->push($history);
        $this->client = new Client([
            'cookies' => $this->jar,
            'timeout' => 30, // 60 seconds
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:132.0) Gecko/20100101 Firefox/132.0',
            ],
            'verify' => false,
            'handler' => $handlerStack,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function fetchWithCookies(string $url, ?array $options = []): ResponseInterface
    {
        $headers = [
            'Accept' => 'text/html, */*; q=0.01',
            'Origin' => $this->siakadUrl,
            'Referer' => "$this->siakadUrl/beranda",
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-origin',
            'Sec-GPC' => '1',
            'X-Requested-With' => 'XMLHttpRequest',
        ];
        if (isset($options['headers'])) {
            $headers = $options['headers'];
            unset($options['headers']);
        }

        return $this->client->request($options['method'] ?? 'GET', $url, array_merge([
            'headers' => $headers,
        ], $options));
    }


    public function postForm(string $url, array $options): ResponseInterface
    {
        $headers = [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'Origin' => $this->siakadUrl,
            'Referer' => "$this->siakadUrl/beranda",
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-origin',
            'Sec-GPC' => '1',
            'Priority' => 'u=0',
            'X-Requested-With' => 'XMLHttpRequest',
        ];
        if (isset($options['headers'])) {
            $headers = array_merge($headers, $options['headers']);
            unset($options['headers']);
        }

        return $this->fetchWithCookies($url, array_merge([
            'headers' => $headers,
            'method' => 'POST',
        ], $options));
    }

    public function login(array $options)   
    {
        try {
            $this->collectSiakadCookies();
        } catch (GuzzleException $th) {
            throw SiakadException::failedToCollectCookies();
        }

        try {
            $url = parse_url($this->siakadUrl);
            $this->jar->clear($url['host'], '/', 'siakad');

            $response = $this->postForm("$this->siakadUrl/login", [
                'form_params' => [
                    'username' => $options['username'],
                    'password' => $options['password'],
                ],
            ]);

            $body = $response->getBody()->getContents();
            $json_body = json_decode($body);

            return $json_body->output === 'ok';
        } catch (GuzzleException $th) {
            error_log($th->getMessage());
        }
    }

    /**
     * @return array<string,mixed>
     *
     * @throws SiakadException
     */


    /**
     * @throws GuzzleException
     */
    public function collectSiakadCookies(): void
    {
        $response = $this->fetchWithCookies($this->siakadUrl, [
            'method' => 'HEAD',
        ]);
        
        // Retain the longest cookie string to ensure active session validity
        $longestSiakadCookie = collect($response->getHeader('Set-Cookie'))
            ->sortBy(fn ($cookie) => strlen($cookie))
            ->last(fn ($cookie) => Str::startsWith($cookie, 'siakad='));
            
        $this->setCookie('siakad', $longestSiakadCookie);
    }

    public function getStudentBio(): array
    {
        try {
            // Extract student name from biodata page
            $bioResponse = $this->fetchWithCookies("$this->siakadUrl/mahasiswa/biodata");
            $bioHtml = $bioResponse->getBody()->getContents();
            $crawlerBio = new Crawler($bioHtml);
            
            $fullname = 'Unknown';
            $email = 'Unknown';

            try {
                $fullnameNode = $crawlerBio->filter('.form-body > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > p:nth-child(1)');
                if ($fullnameNode->count() > 0) {
                    $fullname = trim($fullnameNode->text());
                }
            } catch (\Exception $e) {
                error_log("Failed to extract name: " . $e->getMessage());
            }

            try {
                $emailNode = $crawlerBio->filter('.form-body > div:nth-child(2) > div:nth-child(7) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > p:nth-child(1)');
                if ($emailNode->count() > 0) {
                    $email = trim($emailNode->text());
                }
            } catch (\Exception $e) {
                error_log("Failed to extract email: " . $e->getMessage());
            }

            // Extract student class from history status page using native Regex
            $historyResponse = $this->fetchWithCookies("$this->siakadUrl/mahasiswa/riwayat_status");
            $historyHtml = $historyResponse->getBody()->getContents();
            
            $currentClass = 'Unknown';
            $major = 'Unknown';

            if (preg_match_all('/<tr[^>]*>\s*<td[^>]*>\d+<\/td>\s*<td[^>]*>\d+<\/td>\s*<td[^>]*>(.*?)<\/td>/is', $historyHtml, $matches)) {
                if (!empty($matches[1])) {
                    $classFull = strip_tags(end($matches[1]));
                    $currentClass = explode(' ', trim($classFull))[0];
                    
                    // Extract major from format "2F (TI - 2F)"
                    if (preg_match('/\(([^-]+)\s*-/', $classFull, $majorMatch)) {
                        $major = trim($majorMatch[1]);
                    }
                }
            }

            return [
                'fullname' => $fullname,
                'email' => $email,
                'class' => $currentClass,
                'major' => $major
            ];

        } catch (\Throwable $th) {
            error_log("Siakad Scraping Error: " . $th->getMessage());
            throw SiakadException::failedToCollectBiodata();
        }
    }


    private function setCookie(string $key, string $value): bool
    {
        $url = parse_url($this->siakadUrl);

        return $this->jar->setCookie(new SetCookie([
            'Domain' => $url['host'],
            'Name' => $key,
            'Value' => $value,
        ]));
    }

    public function getCookieJar(): CookieJar
    {
        return $this->jar;
    }
}