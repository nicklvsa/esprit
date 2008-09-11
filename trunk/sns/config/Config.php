<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements. See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership. The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 */

$gadget_server = 'http://localhost/ilos/shindig/php';
$hostname_esprit_conn = "localhost";
$database_esprit_conn = "spicesns";
$username_esprit_conn = "root";
$password_esprit_conn = "";
$esprit_conn = mysql_connect($hostname_esprit_conn, $username_esprit_conn, $password_esprit_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_esprit_conn,$esprit_conn);

?>