--/**
-- * Licensed to the Apache Software Foundation (ASF) under one
-- * or more contributor license agreements. See the NOTICE file
-- * distributed with this work for additional information
-- * regarding copyright ownership. The ASF licenses this file
-- * to you under the Apache License, Version 2.0 (the
-- * "License"); you may not use this file except in compliance
-- * with the License. You may obtain a copy of the License at
-- *
-- * http://www.apache.org/licenses/LICENSE-2.0
-- *
-- * Unless required by applicable law or agreed to in writing,
-- * software distributed under the License is distributed on an
-- * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
-- * KIND, either express or implied. See the License for the
-- * specific language governing permissions and limitations under the License.
-- */

INSERT INTO `user_main` (`user_id`, `user_name`, `user_password`, `user_email`) VALUES 
(1, 'test1', 'test1', 'test1.test1@test1.com'),
(2, 'test2', 'test2', 'test2.test2@test2.com');

INSERT INTO `user_profile` (`user_id`, `first_name`, `last_name`, `Gender`, `user_image`, `profile_url`, `country`, `city`, `interests`, `date_of_birth`) VALUES 
(1, 'test1', 'test1', 'm', 'http://localhost/esprit/userdata/1/pic.jpg', 'http://localhost/esprit/profile.php?userID=59', '98', 'Indore', 'friends,activity partners', '01/01/2008'),
(2, 'test2', 'test2', 'f', 'http://localhost/esprit/userdata/2/pic.jpg', 'http://localhost/esprit/profile.php?userID=60', 'null', NULL, '', '01/01/2008');


INSERT INTO `user_friend` (`user_id`, `friend_id`, `pending`) VALUES 
(1, 2, 'no'),
(2, 1, 'no');

INSERT INTO `user_album` (`user_id`, `photo_id`, `photo_name`, `thumb_name`, `photo_caption`) VALUES 
(1, 1, '365f633089738ddafe982d61073cb55c.jpg', '365f633089738ddafe982d61073cb55c.jpg', 'Mahal'),
(1, 2, '2e2b28e90be49beba25083ce7aa4226f.jpg', '2e2b28e90be49beba25083ce7aa4226f.jpg', 'Nazara'),
(1, 4, '706e24f87df0493e9c73f70824621dc5.jpg', '706e24f87df0493e9c73f70824621dc5.jpg', ''),
(1, 8, '48d77c133b27fd904e6ee5a91415d21a.jpeg', '48d77c133b27fd904e6ee5a91415d21a.jpeg', 'ttt'),
(1, 7, '4ad5af0c7f1440375c0a0014350ad4a7.jpg', '4ad5af0c7f1440375c0a0014350ad4a7.jpg', 'sdfsd'),
(1, 3, '6556a7967021ddb72ab30955f1b3721d.jpg', '6556a7967021ddb72ab30955f1b3721d.jpg', 'yt'),
(2, 1, '31ffbd3eb2b8c59e9bd8f30a6f1ffec2.jpg', '31ffbd3eb2b8c59e9bd8f30a6f1ffec2.jpg', ''),
(2, 2, '206b82a3e0a63e6835e1165ca23c9ba1.jpg', '206b82a3e0a63e6835e1165ca23c9ba1.jpg', ''),
(2, 3, 'f4c9b6b87a3007f5e7da3f131aeded15.jpg', 'f4c9b6b87a3007f5e7da3f131aeded15.jpg', 'ilabs'),
(2, 4, 'dc2460b13327ecb1a425a5a1248c6b5c.jpg', 'dc2460b13327ecb1a425a5a1248c6b5c.jpg', 'Scene');


INSERT INTO `user_online_status` (`user_id`, `last_online_time`, `online_status`) VALUES 
(1, '2008-08-29 17:15:50', 'yes'),
(2, '2008-09-01 16:08:38', 'no');


INSERT INTO `applications` (`id`, `url`, `title`, `directory_title`, `screenshot`, `thumbnail`, `author`, `author_email`, `description`, `settings`, `version`, `height`, `scrolling`, `modified`, `order`, `approved`) VALUES 
(3, 'http://nature.pictures.art.googlepages.com/moons.xml', 'Moon of the Day', 'Moon of the Day', 'http://nature.pictures.art.googlepages.com/moons.ss2.jpg', 'http://nature.pictures.art.googlepages.com/moontnailbestmoonBoston-Skyline-Refl.jpg', 'Paul Olsen', 'paul.olsen8@gmail.com', 'Every day enjoy a beautiful picture of the moon.  Check it out!', 'a:0:{}', '68f50fcd7191b01f5454728a0a6f0be5', 430, 0, 1217435544, 4, 'yes');
