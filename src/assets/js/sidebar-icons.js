/**
 * サイドバーウィジェットにアイコンを追加
 * ※カスタムウィジェット（人気記事・新着記事）は除外
 */
(function() {
  'use strict';

  // DOMContentLoadedで実行
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', addWidgetIcons);
  } else {
    addWidgetIcons();
  }

  /**
   * カスタムウィジェット（人気記事・新着記事）かどうかをチェック
   */
  function isCustomEntryWidget(el) {
    // カスタムウィジェットのクラス名をチェック
    if (el.classList.contains('cielos-popular-entries-widget') ||
        el.classList.contains('cielos-new-entries-widget') ||
        el.classList.contains('unomoon-popular-entries-widget') ||
        el.classList.contains('unomoon-new-entries-widget')) {
      return true;
    }
    // ウィジェットタイトルをチェック
    const title = el.querySelector('.widget-title, h3, h4');
    if (title) {
      const titleText = title.textContent;
      if (titleText.includes('人気記事') || titleText.includes('新着記事')) {
        return true;
      }
    }
    return false;
  }

  function addWidgetIcons() {
    // すべてのasideタグとサイドバーを確認
    const sidebars = document.querySelectorAll('aside, .sidebar, #side-nav');

    /**
     * リンクがカスタムエントリーウィジェット内かチェック
     */
    function isInsideCustomEntryWidget(link) {
      const entryWidget = link.closest('.unomoon-popular-entries-widget, .unomoon-new-entries-widget, .cielos-popular-entries-widget, .cielos-new-entries-widget, .unomoon-entry-list, .cielos-entry-list');
      return entryWidget !== null;
    }

    // 「最近の投稿」と「最新情報」ウィジェットを探す（カスタムウィジェットは除外）
    const recentPostsWidgets = Array.from(document.querySelectorAll('aside, .widget, [class*="widget"]')).filter(function(el) {
      // カスタムウィジェットは除外
      if (isCustomEntryWidget(el)) return false;

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
        // カスタムエントリーウィジェット内のリンクはスキップ
        if (isInsideCustomEntryWidget(link)) return;

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
        // カスタムエントリーウィジェット内のリンクはスキップ
        if (isInsideCustomEntryWidget(link)) return;

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
        // カスタムエントリーウィジェット内のリンクはスキップ
        if (isInsideCustomEntryWidget(link)) return;

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
        // カスタムエントリーウィジェット内のリンクはスキップ
        if (isInsideCustomEntryWidget(link)) return;

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
