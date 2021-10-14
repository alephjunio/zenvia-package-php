<?php

namespace ZenviaSDK\Lib\Channels;

use ZenviaSDK\Lib\Utils\Request;

abstract class AbstractChannel
{

    private $token;
    private $channel;

    /**
     * @param string $text
     */
    public function __construct($token, $channel)
    {
        $this->token = $token;
        $this->channel = $channel;
    }

    /**
     * This method sends the message to the channel.
     *
     * @param from The sender identifier of the message.
     * @param to The recipient identifier of the message.
     * @param contents An array of [[IContent]] object that will be sent.
     * @returns A promise that resolves to an [[IMessage]] object.
     */
    public function sendMessage($from, $to, $contents)
    {
        foreach ($contents as $content) {
            $this->contentSupportValidation($content);
        }
        
        $message = $this->createMessage($from, $to, $contents);
        return $this->request($message);
    }

    /**
     * This method creates a message.
     *
     * @param from The sender identifier of the message.
     * @param to The recipient identifier of the message.
     * @param contents An array of [[IContent]] object that will be sent.
     * @returns An [[IMessageRequest]] object.
     */
    private function createMessage($from, $to, $contents)
    {
        $message = [
            'from' => $from,
            'to' => $to,
            'contents' => []
        ];

        foreach ($contents as $content) {
            array_push($message['contents'], [
                'type' => $content->type,
                'text' => $content->text
            ]);
        }

        return $message;
    }

    /**
   * This method requests to the endpoint.
   *
   * @param message An [[IMessageRequest]] object.
   * @returns A promise that resolves to an [[IMessage]] object.
   */
  private function request($message) {
    $path = "/v2/channels/{$this->channel}/messages";
    return Request::post($this->token, $path, $message);
  }

    abstract protected function contentSupportValidation($content);
}
