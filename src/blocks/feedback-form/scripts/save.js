import {RichText} from "@wordpress/block-editor";
import classNames from "classnames";
export default function Save({attributes}) {
  const _CLASSES = classNames(
    'jabp-feedback-form__heading',
    {
      [`h${attributes.showLevelAs}`]: attributes.showLevelAs,
    }
  );

  return <RichText.Content
    value={!!attributes.content ? attributes.content.trim() : ''}
    tagName={`h${attributes.level}`}
    className={_CLASSES}
  />;
}

