declare module '@wordpress/blocks' {
  export function registerBlockType(name: string, settings: any): any
}

declare module '@wordpress/element' {
  export const createElement: any
  export const useEffect: any
  export const useRef: any
}

declare module '@wordpress/block-editor' {
  export const BlockControls: any
  export const InspectorControls: any
  export const useBlockProps: any
}

declare module '@wordpress/components' {
  export const FontSizePicker: any
  export const PanelBody: any
  export const SelectControl: any
  export const ToolbarDropdownMenu: any
  export const ToolbarGroup: any
}

declare namespace JSX {
  interface IntrinsicElements {
    [elemName: string]: any
  }
}
