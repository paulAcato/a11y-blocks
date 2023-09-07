import {RichText} from "@wordpress/block-editor";
import classNames from "classnames";

export default function Save({attributes}) {
  /**
   * Return string of classNames which updates based on the variation.
   *
   * @type {string}
   * @private
   */
  const _CLASSES = classNames( {
    [`a11y-blocks-heading-${attributes.showAs}`]: !!attributes.showAs,
    [`a11y-blocks-heading-${attributes.tag}`]: !!attributes.tag && !attributes.showAs,
    ['sr-only']: !!attributes.srOnly
  } );

  return <RichText.Content value={attributes.content} tagName={`h${attributes.tag}`} className={_CLASSES} />;
}

