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

/*
* This Code is referred from Partuza (http://code.google.com/p/partuza)
*/

var Container = Class.create();
Container.prototype = {
	maxHeight: 4096,
	
	initialize: function() {
		// rpc services our container supports
		gadgets.rpc.register('resize_iframe', this.setHeight);
		gadgets.rpc.register('set_pref', this.setUserPref);
		gadgets.rpc.register('set_title', this.setTitle);
		gadgets.rpc.register('requestNavigateTo', this.requestNavigateTo);
	},
	
	setHeight: function(height) {
		if ($(this.f) != undefined) {
			// change the height of the gadget iframe, limit to maxHeight height
			if (height > gadgets.container.maxHeight) {
				height = gadgets.container.maxHeight;
			}
			Element.setStyle($(this.f), {'height':height+'px'});
		}
	},
	
	_parseIframeUrl: function(url) {
		// parse the iframe url to extract the key = value pairs from it
		var ret = new Object();
		var hashParams = url.split('&');
		var param = key = val = '';
		for (i = 0 ; i < hashParams.length - 1 ; i++) {
			param = hashParams[i];
			key = param.substr(0, param.indexOf('='));
			val = param.substr(param.indexOf('=') + 1);
			ret[key] = val;
		}
		return ret;
	},
	
	_getUrlForView: function(view, person, app, mod) {
		if (view === 'home') {
			return '/home';
		} else if (view === 'profile') {
			return '/profile/'+person;
		} else if (view === 'canvas') {
			return '/application.php?owner_id='+person+'&app_id'+app+'&mod_id='+mod;
		} else {
			return null;
		}
	},
	
	requestNavigateTo: function(view, opt_params) {
		if ($(this.f) != undefined) {
			var params = gadgets.container._parseIframeUrl($(this.f).src);
			var url = gadgets.container._getUrlForView(view, params.owner, params.aid, params.mid);
			if (opt_params) {
				var paramStr = Object.toJSON(opt_params);
				if (paramStr.length > 0) {
					url += '?appParams=' + encodeURIComponent(paramStr);
				}
			}
			if (url && document.location.href.indexOf(url) == -1) {
	 			document.location.href = url;
			}
		}
	}
}

// Create and initialize our container class
gadgets.container = new Container();
