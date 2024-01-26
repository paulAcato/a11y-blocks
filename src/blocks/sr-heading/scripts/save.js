import {RichText} from "@wordpress/block-editor";

export default function Save({attributes}) {
  return <RichText.Content
    value={!!attributes.content ? attributes.content.trim() : ''}
    tagName={`h${attributes.level}`}
    className="jabp-sr-heading"
  />;
}

