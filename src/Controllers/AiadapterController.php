<?php

namespace Nisha0228\Aiadapter\Controllers;

use Exception;
use Illuminate\Http\Request;
use Nisha0228\Aiadapter\Aiadapter;
use GuzzleHttp\Client;

class AiadapterController
{
    public function __construct()
    {
        $this->openAIKey = config('adapterconfig.api_key');
        $this->openAIEndpoint = config('adapterconfig.api_url');
        $this->model = config('adapterconfig.ai_model');
    }

    public function __invoke(Aiadapter $inspire) {

        $quote = $inspire->justDoIt();

        return view('inspire::index', compact('quote'));
    }

    public function categorize($quiz)
    {

        try {

            $client = new Client();

            $response = $client->post($this->openAIEndpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->openAIKey,
                ],
                'json' => [
                    "model" => $this->model,
                    "messages" => [
                        [
                            "role" => "user",
                            "content" => "$quiz . Please provide the answer, difficulty level (1-3), and theme (Sets and Probability, Geometry, Measurements, Algebra, Statistics, Numbers), with steps."
                        ]
                    ],
                    "temperature" => 1,
                    "max_tokens" => 256,
                    "top_p" => 1,
                    "frequency_penalty" => 0,
                    "presence_penalty" =>0
                ],
            ]);

            // Decode the response
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Extract the relevant data from the response
            $message = $responseData['choices'][0]['message']['content'] ?? 'No response received';

            $response = 'Question:'.$quiz.$message;

            return $response;


        } catch (Exception $exception) {

            return $exception->getMessage();
        }
    }

    public function questions($catcount,$difficulty)
    {
        try {

            $client = new Client();

            $question = "Give me ".$catcount." questions with answers from each theme (Sets and Probability, Geometry, Measurements, Algebra, Statistics, Numbers) with difficulty level of ".$difficulty. "(1-3)";

            $response = $client->post($this->openAIEndpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->openAIKey,
                ],
                'json' => [
                    "model" => $this->model,
                    "messages" => [
                        [
                            "role" => "user",
                            "content" => "$question",
                        ]
                    ],
                    "temperature" => 1,
                    "max_tokens" => 4096,
                    "top_p" => 1,
                    "frequency_penalty" => 0,
                    "presence_penalty" =>0
                ],
            ]);
            
            // Decode the response
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Extract the relevant data from the response
            $message = $responseData['choices'][0]['message']['content'] ?? 'No response received';

            $question = 'Question:'.$catcount.' question from each Theme with the difficulty level of '.$difficulty;

            $fullResponse = $question ."<br>". $message;

            return $fullResponse;

        } catch (Exception $exception) {

            return $exception->getMessage();
        }
    }

    public function theme($theme,$count,$difficulty)
    {
        try {

            $client = new Client();

            $question = "Give me ".$count." questions with answers from the theme ".$theme." of (Sets and Probability, Geometry, Measurements, Algebra, Statistics, Numbers) with the difficulty level of ".$difficulty. "(1-3)";

            $response = $client->post($this->openAIEndpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->openAIKey,
                ],
                'json' => [
                    "model" => $this->model,
                    "messages" => [
                        [
                            "role" => "user",
                            "content" => "$question",
                        ]
                    ],
                    "temperature" => 1,
                    "max_tokens" => 4096,
                    "top_p" => 1,
                    "frequency_penalty" => 0,
                    "presence_penalty" =>0
                ],
            ]);

            // Decode the response
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Extract the relevant data from the response
            $message = $responseData['choices'][0]['message']['content'] ?? 'No response received';

            $question = 'Question:'.$count.' question from Theme '.$theme.' with the difficulty level of '.$difficulty;

            $fullResponse = $question ."<br>". $message;

            return $fullResponse;

        } catch (Exception $exception) {

            return $exception->getMessage();
        }
    }
}
