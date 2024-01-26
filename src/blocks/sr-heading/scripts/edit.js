import {_x, __} from '@wordpress/i18n';
import {BlockControls, RichText} from '@wordpress/block-editor';
import HeadingTagControl from "./controls/heading-tag-control";
import {useState, useMemo} from "@wordpress/element";
import {Notice} from '@wordpress/components';
import {Platform} from '@wordpress/element';
import { createBlock, getDefaultBlockName } from '@wordpress/blocks';
import CombinedNotices from "../../../components/combined-notices";

export default function Edit(
  {
    attributes,
    setAttributes,
    mergeBlocks,
    isSelected,
    clientId,
    onReplace
  }
) {
  const {
    lockPostSaving,
    unlockPostSaving,
    removeBlock
  } = wp.data.dispatch( 'core/editor' );
  const {createNotice, removeNotice} = wp.data.dispatch( 'core/notices' );
  const [locks, setLocks] = useState( {} );

  /**
   * Lock/Unlock the save button and show notices.
   * @param {boolean} lockIt Lock the editor.
   * @param {string} handle The ID of the notice, used for the notices loop;
   * @param {string} message The message to show to the user.
   * @param {string} type The type of the notices, eq: success, error, warning, info.
   * @param {boolean} isDismissible if the notice is dismissible.
   */
  const lock = (lockIt = false, handle = '', message = '', type = 'error', isDismissible = true) => {
    if (!handle || !message || !clientId) {
      return;
    }

    if (lockIt) {
      if (!locks[handle]) {
        setLocks( {...locks, [handle]: {type: type, message: message}} );

        const actions = [
          {
            label: __( 'Go to the block', 'jabp' ),
            onClick: () => document.getElementById( `block-${clientId}` ).scrollIntoView( {
              behavior: "smooth",
              block: "start",
              inline: "nearest"
            } ),
          },
          {
            label: __( 'Remove block', 'jabp' ),
            onClick: () => {
              removeBlock( clientId );
              maybeUnlockEditor( handle );
            }
          }
        ];

        lockPostSaving( handle );
        createNotice( type, message, {
          id: handle,
          isDismissible: isDismissible,
          actions: actions
        } );
      }
    } else if (locks[handle]) {
      maybeUnlockEditor( handle );
    }
  }

  /**
   * Check if it must unlock the editor. This is done by checking if one of the handles is still in the locks array.
   * uses the useState locks/setLocks to remove the current handle from the array.
   * @param {string} handle The handle to check.
   */
  const maybeUnlockEditor = handle => {
    setLocks( Array.from( locks ).filter( item => item[handle] !== handle ) );
    removeNotice( handle )
    unlockPostSaving( handle );
  }

  lock( !attributes.content && !isSelected, `${clientId}-warning`, __( 'Please remove or populate the empty Screen reader heading, saving the page will be disabled in the meantime.', 'jabp' ), 'warning' );

  return (
    <>
      <BlockControls>
        <HeadingTagControl level={attributes.level} setAttributes={setAttributes} />
      </BlockControls>

      <CombinedNotices notices={locks} />

      <RichText
        identifier="content"
        tagName={`h${attributes.level}`}
        value={attributes.content}
        className="jabp-sr-heading"
        allowedFormats={[]}
        placeholder={_x( 'Enter your heading for screen readers…', 'Placeholder', 'jabp' )}
        onChange={(content) => {
          // Remove `<meta charset="utf-8">` from copy-and-paste actions.
          if (content.includes( '<meta charset="utf-8">' )) {
            content = content.replace( /<meta charSet="utf-8">/gmi, '' ).trim()
          }
          setAttributes( {content} );
        }}
        onMerge={ mergeBlocks }
        onSplit={ ( content, isOriginal ) => {
          let block;

          if ( isOriginal || content ) {
            block = createBlock( 'jabp/sr-heading', {
              ...attributes,
              content,
            } );
          } else {
            block = createBlock( getDefaultBlockName() ?? 'jabp/sr-heading' );
          }

          if ( isOriginal ) {
            block.clientId = clientId;
          }

          return block;
        } }
        onReplace={ onReplace }
        onRemove={ () => onReplace( [] ) }
        {...(Platform.isNative && {deleteEnter: true})}
      />
    </>
  );
}
