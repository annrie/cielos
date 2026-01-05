/**
 * サイドバーウィジェットにアイコンを追加
 */
(function() {
  'use strict';

  

  // DOMContentLoadedで実行
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', addWidgetIcons);
  } else {
    addWidgetIcons();
  }

  function addWidgetIcons() {
    

    // すべてのasideタグとサイドバーを確認
    const sidebars = document.querySelectorAll('aside, .sidebar, #side-nav');

    // 「最近の投稿」と「最新情報」ウィジェットを探す
    const recentPostsWidgets = Array.from(document.querySelectorAll('aside, .widget, [class*="widget"]')).filter(function(el) {
      const title = el.querySelector('.widget-title, h3, h4');
      return title && (
        title.textContent.includes('最近の投稿') ||
        title.textContent.includes('Recent Posts') ||
        title.textContent.includes('最新情報') ||
        title.textContent.includes('Latest Information')
      );
    });

    

    // 最近の投稿・最新情報ウィジェット内のリンクにアイコンを追加
    recentPostsWidgets.forEach(function(widget) {
      const links = widget.querySelectorAll('ul li a');

      links.forEach(function(link) {
        // 既に何らかのアイコンが追加されているかチェック
        if (!link.querySelector('i[class*="i-carbon-"]')) {
          const icon = document.createElement('i');
          icon.className = 'i-carbon-document inline-block mr-2 text-[var(--c-accent)]';
          icon.setAttribute('aria-hidden', 'true');
          link.prepend(icon);
          
        }
      });
    });

    // カテゴリーウィジェットにアイコンを追加
    const categoriesWidgets = Array.from(document.querySelectorAll('aside, .widget, [class*="widget"]')).filter(function(el) {
      const title = el.querySelector('.widget-title, h3, h4');
      return title && (title.textContent.includes('カテゴリー') || title.textContent.includes('Categories'));
    });

    

    categoriesWidgets.forEach(function(widget) {
      const links = widget.querySelectorAll('ul li a');

      links.forEach(function(link) {
        // 既に何らかのアイコンが追加されているかチェック
        if (!link.querySelector('i[class*="i-carbon-"]')) {
          const icon = document.createElement('i');
          icon.className = 'i-carbon-folder inline-block mr-2 text-[var(--c-accent)]';
          icon.setAttribute('aria-hidden', 'true');
          link.prepend(icon);
          
        }
      });
    });

    // アーカイブウィジェットにアイコンを追加
    const archivesWidgets = Array.from(document.querySelectorAll('aside, .widget, [class*="widget"]')).filter(function(el) {
      const title = el.querySelector('.widget-title, h3, h4');
      return title && (title.textContent.includes('アーカイブ') || title.textContent.includes('Archives'));
    });

    

    archivesWidgets.forEach(function(widget) {
      const links = widget.querySelectorAll('ul li a');

      links.forEach(function(link) {
        // 既に何らかのアイコンが追加されているかチェック
        if (!link.querySelector('i[class*="i-carbon-"]')) {
          const icon = document.createElement('i');
          icon.className = 'i-carbon-calendar inline-block mr-2 text-[var(--c-accent)]';
          icon.setAttribute('aria-hidden', 'true');
          link.prepend(icon);
          
        }
      });
    });

    // 「僭越図書館」ウィジェット（固定ページリスト）にアイコンを追加
    const libraryWidgets = Array.from(document.querySelectorAll('aside, .widget, [class*="widget"]')).filter(function(el) {
      const title = el.querySelector('.widget-title, h3, h4');
      return title && title.textContent.includes('僭越図書館');
    });

    

    libraryWidgets.forEach(function(widget) {
      const links = widget.querySelectorAll('ul li a');

      links.forEach(function(link) {
        // 既に何らかのアイコンが追加されているかチェック
        if (!link.querySelector('i[class*="i-carbon-"]')) {
          const icon = document.createElement('i');
          icon.className = 'i-carbon-book inline-block mr-2 text-[var(--c-accent)]';
          icon.setAttribute('aria-hidden', 'true');
          link.prepend(icon);
          
        }
      });
    });

    
  }
})();
