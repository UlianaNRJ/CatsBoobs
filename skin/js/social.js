var _ga = _ga || {};
var _gaq = _gaq || [];

_gaq.push(['_setAccount', 'UA-29904811-1']);
_gaq.push(['_setDomainName', 'catsboobs.com']);
_gaq.push(['_trackPageview']);

_ga.trackFacebook = function (opt_pageUrl, opt_trackerName) {
	var trackerName = _ga.buildTrackerName_(opt_trackerName);
	try {
		if (FB && FB.Event && FB.Event.subscribe) {
			FB.Event.subscribe('edge.create', function (targetUrl) {
				_gaq.push([trackerName + '_trackSocial', 'facebook', 'like', targetUrl, opt_pageUrl]);
			});
			FB.Event.subscribe('edge.remove', function (targetUrl) {
				_gaq.push([trackerName + '_trackSocial', 'facebook', 'unlike', targetUrl, opt_pageUrl]);
			});
			FB.Event.subscribe('message.send', function (targetUrl) {
				_gaq.push([trackerName + '_trackSocial', 'facebook', 'send', targetUrl, opt_pageUrl]);
			});
		}
	} catch (e) {
	}
};

_ga.trackTwitter = function (opt_pageUrl, opt_trackerName) {
	var trackerName = _ga.buildTrackerName_(opt_trackerName);
	try {
		if (twttr && twttr.events && twttr.events.bind) {
			twttr.events.bind('tweet', function (event) {
				if (event) {
					var targetUrl; // Default value is undefined.
					if (event.target && event.target.nodeName == 'IFRAME') {
						targetUrl = _ga.extractParamFromUri_(event.target.src, 'url');
					}
					_gaq.push([trackerName + '_trackSocial', 'twitter', 'tweet',
						targetUrl, opt_pageUrl]);
				}
			});
		}
	} catch (e) {
	}
};

_ga.trackVkontakte = function (opt_pageUrl, opt_trackerName, opt_targetUrl) {
	var trackerName = _ga.buildTrackerName_(opt_trackerName);
	try {
		if (VK && VK.Observer && VK.Observer.subscribe) {
			VK.Observer.subscribe('widgets.like.liked', function () {
				_gaq.push([trackerName + '_trackSocial', 'vkontakte', 'like', opt_targetUrl, opt_pageUrl]);
			});
			VK.Observer.subscribe('widgets.like.unliked', function () {
				_gaq.push([trackerName + '_trackSocial', 'vkontakte', 'unlike', opt_targetUrl, opt_pageUrl]);
			});
		}
	} catch (e) {
	}
};

_ga.buildTrackerName_ = function (opt_trackerName) {
	return opt_trackerName ? opt_trackerName + '.' : '';
};

_ga.extractParamFromUri_ = function (uri, paramName) {
	if (!uri) {
		return;
	}
	var uri = uri.split('#')[0];  // Remove anchor.
	var parts = uri.split('?');  // Check for query params.
	if (parts.length == 1) {
		return;
	}
	var query = decodeURI(parts[1]);

	// Find url param.
	paramName += '=';
	var params = query.split('&');
	for (var i = 0, param; param = params[i]; ++i) {
		if (param.indexOf(paramName) === 0) {
			return unescape(param.split('=')[1]);
		}
	}
	return;
};


_ga.trackSocial = function (opt_pageUrl, opt_trackerName) {
	_ga.trackFacebook(opt_pageUrl, opt_trackerName);
	_ga.trackTwitter(opt_pageUrl, opt_trackerName);
	_ga.trackVkontakte(opt_pageUrl, opt_trackerName);
};

_ga.trackSocial();