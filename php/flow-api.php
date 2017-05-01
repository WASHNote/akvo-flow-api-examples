<?php
/*
 *  Copyright (C) 2014 Stichting Akvo (Akvo Foundation)
 *
 *  This file is part of Akvo FLOW.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

$access_key = $argv[1];
$secret = $argv[2];
$url = $argv[3];

$date = time(); // UNIX timestamp

$resource = substr($url, strpos($url, "/api/v1"));
$res_parts = split("\?", $resource);

$payload = "GET\n$date\n" . $res_parts[0];

$signature = base64_encode(hash_hmac("sha1", $payload, $secret, TRUE));

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Date: $date", "Authorization: $access_key:$signature"));

curl_exec($curl);
curl_close($curl);

?>
