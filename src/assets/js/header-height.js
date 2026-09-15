/**
 * 実際のヘッダー高を CSS 変数 --header-h-actual に反映する。
 * --header-h はデザイントークン(min-height)で、実際の高さはロゴやヘッダー種別で変わるため、
 * ヘッダー直下に画面ぴったりで収めたい要素(.section-hero など)はこちらを参照する。
 */
(function () {
  var header = document.getElementById('header')
  if (!header) return
  var root = document.documentElement
  var apply = function () {
    root.style.setProperty('--header-h-actual', header.offsetHeight + 'px')
  }
  apply()
  if ('ResizeObserver' in window) {
    new ResizeObserver(apply).observe(header)
  } else {
    window.addEventListener('resize', apply)
  }
  window.addEventListener('load', apply)
})()
