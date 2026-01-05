/**
 * 言語別タブ切り替え UI
 *
 * 使用法:
 * <div class="lang-tabs">
 *   <div class="tab-item" data-tab="perl">...コンテンツ...</div>
 *   <div class="tab-item"><h3>python</h3>...コンテンツ...</div>
 *   <div class="tab-item"><div>java</div>...コンテンツ...</div>
 * </div>
 *
 * タブ名の優先順位:
 * 1. data-tab 属性
 * 2. 最初の子要素（h1-h6, div, p, span）のテキスト
 * 3. フォールバック: "Tab N"
 */
;(function () {
  'use strict'

  /**
   * タブ名を取得する
   * @param {HTMLElement} item - tab-item 要素
   * @param {number} index - タブのインデックス
   * @returns {{ name: string, labelEl: HTMLElement|null }}
   */
  function getTabName(item, index) {
    // 1. data-tab 属性があればそれを使用
    if (item.dataset.tab) {
      return { name: item.dataset.tab, labelEl: null }
    }

    // 2. DOM 順で最初の p 要素を探す（タブ名用）
    // Gutenberg は <p>タブ名</p> を wp-block-group 内にラップする
    const firstP = item.querySelector('p')
    if (firstP) {
      const text = firstP.textContent.trim()
      // 短いテキスト（タブ名らしい: 30文字以下、子要素なし）
      if (text && text.length <= 30 && !firstP.querySelector('*')) {
        firstP.classList.add('tab-label')
        return { name: text, labelEl: firstP }
      }
    }

    // 3. フォールバック
    return { name: 'Tab ' + (index + 1), labelEl: null }
  }

  function initLangTabs() {
    const containers = document.querySelectorAll('.lang-tabs')
    if (!containers.length) return

    containers.forEach(function (container) {
      // 既に初期化済みならスキップ
      if (container.querySelector('.lang-tabs-nav')) return

      // Gutenberg のグループブロックは追加のラッパーを生成するため、
      // .tab-item を任意の深さで検索（ただしネストされたタブは除外）
      const items = Array.from(container.querySelectorAll('.tab-item')).filter(function(item) {
        // 親に別の .lang-tabs がないことを確認（ネスト対応）
        return item.closest('.lang-tabs') === container
      })
      if (!items.length) return

      // タブナビゲーションを生成
      const nav = document.createElement('div')
      nav.className = 'lang-tabs-nav'
      nav.setAttribute('role', 'tablist')

      const tabs = []
      items.forEach(function (item, index) {
        // タブ名を取得
        const { name: tabName } = getTabName(item, index)
        const tabId = 'tab-' + tabName.toLowerCase().replace(/[^a-z0-9]/g, '-') + '-' + index
        const panelId = 'panel-' + tabName.toLowerCase().replace(/[^a-z0-9]/g, '-') + '-' + index

        // タブボタンを作成
        const btn = document.createElement('button')
        btn.textContent = tabName
        btn.setAttribute('role', 'tab')
        btn.setAttribute('aria-selected', index === 0 ? 'true' : 'false')
        btn.setAttribute('aria-controls', panelId)
        btn.setAttribute('id', tabId)
        btn.setAttribute('tabindex', index === 0 ? '0' : '-1')

        // パネルに属性を設定
        item.setAttribute('role', 'tabpanel')
        item.setAttribute('id', panelId)
        item.setAttribute('aria-labelledby', tabId)

        // 初期状態
        if (index === 0) {
          item.classList.add('is-active')
        } else {
          item.classList.remove('is-active')
        }

        // クリックイベント
        btn.addEventListener('click', function () {
          activateTab(container, index)
        })

        // キーボード操作
        btn.addEventListener('keydown', function (e) {
          handleKeydown(e, tabs, index)
        })

        nav.appendChild(btn)
        tabs.push(btn)
      })

      // ナビゲーションを挿入
      container.insertBefore(nav, container.firstChild)
    })
  }

  function activateTab(container, activeIndex) {
    const nav = container.querySelector('.lang-tabs-nav')
    const buttons = nav.querySelectorAll('button')
    const items = container.querySelectorAll('.tab-item')

    buttons.forEach(function (btn, i) {
      const isActive = i === activeIndex
      btn.setAttribute('aria-selected', isActive ? 'true' : 'false')
      btn.setAttribute('tabindex', isActive ? '0' : '-1')
    })

    items.forEach(function (item, i) {
      if (i === activeIndex) {
        item.classList.add('is-active')
      } else {
        item.classList.remove('is-active')
      }
    })

    // フォーカスを移動
    buttons[activeIndex].focus()
  }

  function handleKeydown(e, tabs, currentIndex) {
    let newIndex = currentIndex

    switch (e.key) {
      case 'ArrowLeft':
        newIndex = currentIndex > 0 ? currentIndex - 1 : tabs.length - 1
        e.preventDefault()
        break
      case 'ArrowRight':
        newIndex = currentIndex < tabs.length - 1 ? currentIndex + 1 : 0
        e.preventDefault()
        break
      case 'Home':
        newIndex = 0
        e.preventDefault()
        break
      case 'End':
        newIndex = tabs.length - 1
        e.preventDefault()
        break
      default:
        return
    }

    tabs[newIndex].click()
  }

  // DOM 準備完了後に初期化
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLangTabs)
  } else {
    initLangTabs()
  }
})()
