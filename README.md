OneSignal Push messaging extension for Bolt CMS
===============================================

Onesignal https://onesignal.com/ is a cool push messaging service provider. 
This starter extension focuses currently a simple hot-plug implementation of Web Push services
under any Bolt CMS site. (See Web Push SDK services here: https://documentation.onesignal.com/v3.0/docs/web-push-sdk)

In other hand OneSignal offers many SDK feature that this extension doesn't implement currently, although with this 
 basic extension you can reach a wide range of OneSignal features. Stat, central message composition and monitoring, etc. 
It is gladly welcome any contribution moving forward this stuff.


OneSignal extension
======================

### Installation

1. Login to your Bolt installation
2. Go to "Extend" or "Extras > Extend"
3. Type `onesignal` into the input field
4. Click on the extension name
5. Click on "Browse Versions"
6. Click on "Install This Version" on the latest stable version

### Configuration

See `config.yml.dist` as our default config skeleton and check Web Push SDK Init options available here. 
https://documentation.onesignal.com/v3.0/docs/web-push-sdk#section--init-
Under `config.yml#init` section you may introduce all of necessary entry you would like to pass to Web Push SDK 
 initialization.
 

---

### License

This Bolt extension is open-sourced software licensed under the [MIT License]

### Change log

2017-06-18 Added extension icon as a #1555 like feature :)
