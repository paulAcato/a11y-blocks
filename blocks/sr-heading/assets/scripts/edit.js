import {_x, __} from '@wordpress/i18n';
import {BlockControls, RichText} from '@wordpress/block-editor';
import HeadingTagControl from "./controls/heading-tag-control";
import {useState, useMemo} from "@wordpress/element";
import {Notice} from '@wordpress/components';

export default function Edit(
  {
    attributes,
    setAttributes,
    mergeBlocks,
    isSelected,
    clientId
  }
) {
  const {
    lockPostSaving,
    unlockPostSaving,
    removeBlock,
    getBlocksByClientId,
    insertBlock
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
            label: __( 'Go to the block', 'a11y-blocks' ),
            onClick: () => document.getElementById( `block-${clientId}` ).scrollIntoView( {
              behavior: "smooth",
              block: "start",
              inline: "nearest"
            } ),
          },
          {
            label: __( 'Remove block', 'a11y-blocks' ),
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

  lock( !attributes.content && !isSelected, `${clientId}-warning`, __( 'Please remove or populate the empty Screen reader heading, saving the page will be disabled in the meantime.', 'a11y-blocks' ), 'warning' );

  /**
   * Combine all notices and show in the block.
   * @type {*[]}
   */
  const combinedNotices = useMemo( () => {
    if (!locks || Object.keys( locks ).length === 0) {
      return;
    }

    return Object.values( locks ).map( ({type, message}) => <Notice status={type} isDismissible={false}>{message}</Notice> );
  }, [locks] );

  return (
    <>
      <BlockControls>
        <HeadingTagControl tag={attributes.tag} setAttributes={setAttributes} />
      </BlockControls>

      {combinedNotices}

      <RichText
        identifier="content"
        tagName={`h${attributes.tag}`}
        value={attributes.content}
        onChange={(text) => {
          // Remove `<meta charset="utf-8">` from copy-and-paste actions.
          if (text.includes( '<meta charset="utf-8">' )) {
            text = text.replace( /<meta charSet="utf-8">/gmi, '' ).trim()
          }
          setAttributes( {content: text} )
        }}
        onRemove={() => onReplace( [] )}
        onMerge={mergeBlocks}
        className="a11y-blocks-screenreader-heading"
        allowedFormats={[]}
        placeholder={_x( 'Enter your heading for screen readers…', 'Placeholder', 'a11y-blocks' )}
        multiline={false}
        onReplace={() => {
        }}
      />
    </>
  );
}
