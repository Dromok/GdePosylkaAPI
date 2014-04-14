<?php
/**
 * Класс для взаимодействия с API сервиса GdePosylka.ru
 *
 * Краткая справка:
 * Вы должны обладать API-ключом. Получить его можно на сайте http://gdeposylka.ru/ в меню "Профиль".
 * Для отслеживания нового трека предварительно его необходимо добавить методом trackAdd.
 * Для получения данных о треке можно воспользоваться методом trackStatus.
 *
 * Описание API можно найти по адресу https://code.google.com/p/gdeposylka-api/wiki/API_X1
 */

class GdePosylkaAPI {

    const API_URL = "http://gdeposylka.ru/ws/x1/";

    protected $apikey;

    /*
     * Обязательно надо указать API-ключ
     * @param string $apikey
     */
    public function __construct($apikey)
    {
        if(!empty($apikey))
            $this->apikey = $apikey;
    }

    /*
     * Добавление трека.
     * @param string $trackId Номер трека. Пример, CJ247232572US.
     * @return array
     */
    public function trackAdd($trackId)
    {
        $response = $this->makeRequest($trackId, 'track.add');
        return $response;
    }

    /*
     * Получение информации о треке.
     * @param string $trackId Номер трека. Пример, CJ247232572US.
     * @return array
     */
    public function trackStatus($trackId)
    {
        $response = $this->makeRequest($trackId, 'track.status');
        return $response;
    }

    /*
     * Обращение к апи ГдеПосылки.
     * @param string $trackId Номер трека.
     * @param string $method Метод апи.
     * @return array
     */
    protected function makeRequest($trackId, $method) {
        if(!$this->apikey || !$method || !$trackId) return -1;

        $channel = curl_init(self::API_URL.$method.'/json?apikey='.$this->apikey.'&id='.$trackId);

        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($channel);
        if ($errorCode = curl_errno($channel)) {
            return $errorCode;
        }

        return json_decode($result);
    }

}