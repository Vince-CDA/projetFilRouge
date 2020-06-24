'use strict';
/*-----------------------------------------------
|   Variables
-----------------------------------------------*/

/*
  global opr, safari
*/

/*-----------------------------------------------
|   Detector
-----------------------------------------------*/

var Detector = {
  isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(Utils.nua),
  isOSX: Utils.nua.match(/(iPad|iPhone|iPod|Macintosh)/g),
  isOpera: !!window.opr && !!opr.addons || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0,
  isFirefox: typeof InstallTrigger !== 'undefined',
  isSafari: /constructor/i.test(window.HTMLElement) || function (p) {
    return p.toString() === '[object SafariRemoteNotification]';
  }(!window.safari || safari.pushNotification),
  isNewerIE: Utils.nua.match(/msie (9|([1-9][0-9]))/i),
  isOlderIE: Utils.nua.match(/msie/i) && !this.isNewerIE,
  isAncientIE: Utils.nua.match(/msie 6/i),
  isIE: this.isAncientIE || this.isOlderIE || this.isNewerIE,
  isIE11: !!window.MSInputMethodContext && !!document.documentMode,
  isEdge: !this.isIE11 && !this.isIE && !!window.StyleMedia,
  isChrome: !!window.chrome && !!window.chrome.webstore,
  isBlink: (this.isChrome || this.isOpera) && !!window.CSS,
  isPuppeteer: Utils.nua.match(/puppeteer/i),
  isIOS: parseFloat((/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(Utils.nua) || [0, ''])[1].replace('undefined', '3_2').replace('_', '.').replace('_', '')) || false,
  iPadiPhoneFirefox: Utils.nua.match(/iPod|iPad|iPhone/g) && Utils.nua.match(/Gecko/g),
  macFirefox: Utils.nua.match(/Macintosh/g) && Utils.nua.match(/Gecko/g) && Utils.nua.match(/rv:/g),
  isAndroid: Utils.nua.indexOf('Mozilla/5.0') > -1 && Utils.nua.indexOf('Android ') > -1 && Utils.nua.indexOf('AppleWebKit') > -1
};
Utils.$document.ready(function () {
  if (Detector.isOpera) Utils.$html.addClass('opera');
  if (Detector.isMobile) Utils.$html.addClass('mobile');
  if (Detector.isOSX) Utils.$html.addClass('osx');
  if (Detector.isFirefox) Utils.$html.addClass('firefox');
  if (Detector.isSafari) Utils.$html.addClass('safari');
  if (Detector.isIOS) Utils.$html.addClass('ios');
  if (Detector.isIE || Detector.isIE11) Utils.$html.addClass('ie');
  if (Detector.isEdge) Utils.$html.addClass('edge');
  if (Detector.isChrome) Utils.$html.addClass('chrome');
  if (Detector.isBlink) Utils.$html.addClass('blink');
  if (Detector.isPuppeteer) Utils.$html.addClass('puppeteer');
});