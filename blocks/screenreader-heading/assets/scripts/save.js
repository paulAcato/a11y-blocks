import {RichText} from "@wordpress/block-editor";

export default function Save({attributes}) {
  return <RichText.Content value={attributes.content} tagName={`h${attributes.tag}`} className="a11y-blocks-screenreader-heading" />;
}

