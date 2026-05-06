/**
 * Navigation Control - Minimal JavaScript for navigation functionality
 * Replaces nav-enforcer with clean, maintainable code
 */
(() => {
  'use strict'

  // ========================================
  // 1. Theme Toggle
  // ========================================
  const initThemeToggle = () => {
    const KEY = 'cielos:theme'
    const root = document.documentElement
    const sys = window.matchMedia('(prefers-color-scheme: dark)')

    const isDarkResolved = (v) => {
      if (v === 'system')
        return sys.matches
      return v === 'dark'
    }

    const current = () => localStorage.getItem(KEY) || 'system'

    // アイコン同期（3状態: light/dark/system）
    // data-theme-toggle 属性を持つ全ボタンを対象
    const syncIcons = (mode) => {
      document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        const sun = btn.querySelector('[data-icon="sun"]')
        const moon = btn.querySelector('[data-icon="moon"]')
        const system = btn.querySelector('[data-icon="system"]');

        // すべて非表示にしてから、該当するものだけ表示
        [sun, moon, system].forEach((icon) => {
          if (icon) {
            icon.style.display = 'none'
            icon.style.visibility = 'hidden'
            icon.style.opacity = '0'
          }
        })

        // モードに応じたアイコンを表示
        let activeIcon = null
        switch (mode) {
          case 'light':
            activeIcon = sun
            break
          case 'dark':
            activeIcon = moon
            break
          case 'system':
          default:
            activeIcon = system
            break
        }

        if (activeIcon) {
          activeIcon.style.display = 'block'
          activeIcon.style.visibility = 'visible'
          activeIcon.style.opacity = '1'
        }
      })
    }

    // 初期適用
    const initialMode = current()
    const initialDark = isDarkResolved(initialMode)
    root.classList.toggle('dark', initialDark)
    root.style.colorScheme = initialDark ? 'dark' : 'light'

    // アイコン初期同期（遅延実行で確実に）
    setTimeout(syncIcons, 50, initialMode)

    // 3段階切り替え: light → dark → system → light...
    const nextTheme = (currentTheme) => {
      switch (currentTheme) {
        case 'light': return 'dark'
        case 'dark': return 'system'
        case 'system':
        default: return 'light'
      }
    }

    // ボタン機能付与 - data-theme-toggle 属性を持つ全ボタンを対象
    const wireButtons = () => {
      document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        if (btn.dataset.wired)
          return

        btn.dataset.wired = '1'
        btn.addEventListener('click', (e) => {
          e.preventDefault()

          const newTheme = nextTheme(current())
          localStorage.setItem(KEY, newTheme)

          const newDark = isDarkResolved(newTheme)
          root.classList.toggle('dark', newDark)
          root.style.colorScheme = newDark ? 'dark' : 'light'

          syncIcons(newTheme)
        })
      })
    }

    wireButtons()

    // システム変更監視
    sys.addEventListener('change', () => {
      const mode = current()
      if (mode === 'system') {
        const systemDark = sys.matches
        root.classList.toggle('dark', systemDark)
        root.style.colorScheme = systemDark ? 'dark' : 'light'
        // systemモード中はアイコンは system のまま（変更不要）
      }
    })
  }

  // ========================================
  // 2. Mobile Menu Toggle
  // ========================================
  const initMobileMenu = () => {
    const hamburger = document.querySelector('[data-toggle="mobile-menu"]')
    const mobileMenu = document.getElementById('mobile-menu')

    if (!hamburger || !mobileMenu) {
      return
    }

    // 初期状態設定
    mobileMenu.removeAttribute('data-open')
    hamburger.setAttribute('aria-expanded', 'false')

    // ハンバーガークリック
    if (!hamburger.dataset.wired) {
      hamburger.dataset.wired = '1'
      hamburger.addEventListener('click', (e) => {
        e.preventDefault()
        e.stopPropagation()

        const isOpen = mobileMenu.hasAttribute('data-open')

        if (isOpen) {
          mobileMenu.removeAttribute('data-open')
          hamburger.setAttribute('aria-expanded', 'false')
        }
        else {
          mobileMenu.setAttribute('data-open', '')
          hamburger.setAttribute('aria-expanded', 'true')
        }
      })
    }
  }

  // ========================================
  // 3. Submenu Toggle
  // ========================================
  const initSubmenuToggle = () => {
    const mobileMenu = document.getElementById('mobile-menu')
    if (!mobileMenu)
      return

    // サブメニュートグルを検索
    const selectors = [
      '.submenu-toggle-icon',
      '.submenu-toggle',
      'button[aria-controls]',
      'li[aria-expanded] > div > button',
    ]

    const allToggles = new Set()
    selectors.forEach((selector) => {
      const found = mobileMenu.querySelectorAll(selector)
      found.forEach(el => allToggles.add(el))
    })

    allToggles.forEach((toggle) => {
      if (toggle.dataset.wired)
        return
      toggle.dataset.wired = '1'

      toggle.addEventListener('click', (e) => {
        e.preventDefault()
        e.stopPropagation()

        const li = toggle.closest('li')
        if (!li)
          return

        const isExpanded = li.getAttribute('aria-expanded') === 'true'
        const newExpanded = !isExpanded
        li.setAttribute('aria-expanded', String(newExpanded))
      })
    })
  }

  // ========================================
  // 初期化
  // ========================================
  const init = () => {
    initThemeToggle()

    // 画面サイズ別初期化
    if (window.innerWidth < 1024) {
      initMobileMenu()
      initSubmenuToggle()
    }

    // リサイズ対応
    let resizeTimeout
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout)
      resizeTimeout = setTimeout(() => {
        if (window.innerWidth < 1024) {
          initMobileMenu()
          initSubmenuToggle()
        }
      }, 100)
    })
  }

  // 実行
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
  }
  else {
    init()
  }

  // 追加の安全策：遅延実行で再度確実化
  setTimeout(() => {
    if (window.innerWidth < 1024) {
      initSubmenuToggle()
    }
  }, 100)
})()
