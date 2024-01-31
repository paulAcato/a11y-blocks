import {__, _x} from '@wordpress/i18n';
import {BlockControls, RichText} from '@wordpress/block-editor';
import {useState, useMemo, Platform} from "@wordpress/element";
import CombinedNotices from "../../../components/combined-notices";
import classNames from "classnames";
import {ToolbarGroup} from "@wordpress/components";
import {
  check as checkIcon,
  closeSmall as crossIcon,
  plus as plusIcon,
  lineSolid as minIcon
} from '@wordpress/icons';
import StyleControl from "./controls/style-control";
import {createBlock, getDefaultBlockName} from "@wordpress/blocks";
import HeadingTagControl from "../../../controls/heading-tag-control";

export default function Edit(
  {
    attributes,
    setAttributes,
    mergeBlocks,
    isSelected,
    clientId,
    onReplace,
    name
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

  lock( !attributes.content && !isSelected, `${clientId}-warning`, __( 'Please populate the empty heading, saving the page will be disabled in the meantime.', 'jabp' ), 'warning' );

  const _CLASSES = useMemo( () => {
    return {
      root: classNames( 'jabp-feedback-form', {
        [`jabp-feedback-form--style-${attributes.style}`]: attributes.style
      } ),
      button: classNames( 'jabp-feedback-form__btn', {
        [`jabp-feedback-form__btn--${attributes.buttonStyle}`]: attributes.buttonStyle
      } ),
      heading: classNames( 'jabp-feedback-form__heading', {
        [`h${attributes.showLevelAs}`]: attributes.showLevelAs,
      } )
    }
  }, [attributes.style, attributes.buttonStyle, attributes.showLevelAs] );

  const memoizedIcons = useMemo( () => {
    switch (attributes.style) {
      case 1:
        return [<svg aria-hidden="true" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
          <path
            d="M695.559-166.154H300v-430.154l246.462-243.385 15.846 15.231q5.346 5.962 8.827 13.926t3.481 14.591v5.637l-40.308 194h278q23.731 0 42.635 18.904 18.903 18.904 18.903 42.635v48.128q0 5.365-.859 11.716-.859 6.352-2.987 11.387L761.96-208.986q-7.792 18.648-27.145 30.74-19.353 12.092-39.256 12.092Zm-358.636-36.923h359.692q8.462 0 17.308-4.615 8.846-4.616 13.462-15.385l109.538-256.808v-54.884q0-10.77-6.923-17.693-6.923-6.923-17.692-6.923H488.923l45.577-217.23-197.577 195.653v377.885Zm0-377.885v377.885-377.885ZM300-596.308v36.923H163.692v356.308H300v36.923H126.769v-430.154H300Z" />
        </svg>,
          <svg aria-hidden="true" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path
              d="M265.056-759.693h395.559v430.155L414.154-86.154l-15.847-15.231q-5.346-5.961-8.827-13.925-3.48-7.964-3.48-14.591v-5.638l40.307-193.999H148.308q-23.731 0-42.635-18.904-18.904-18.904-18.904-42.635v-48.128q0-5.365.859-11.717.859-6.351 2.987-11.386l108.041-254.553q7.791-18.648 27.144-30.74 19.354-12.092 39.256-12.092Zm358.636 36.924H264q-8.462 0-17.308 4.615t-13.461 15.384L123.692-446.475v55.398q0 10.769 6.923 17.692t17.693 6.923h323.384L426.5-149.231l197.192-196.038v-377.5Zm0 377.5V-722.769v377.5Zm36.923 15.731v-36.924h136.308v-356.307H660.615v-36.924h173.231v430.155H660.615Z" />
          </svg>
        ];

      case 2:
        return [checkIcon, crossIcon];

      case 3:
        return [plusIcon, minIcon]

      default:
        return [null, null];
    }
  }, [attributes.style] );

  return (
    <>
      <BlockControls>
        <ToolbarGroup>
          <StyleControl style={attributes.style} setAttributes={setAttributes} />
        </ToolbarGroup>
        <ToolbarGroup>
          <HeadingTagControl level={attributes.level} setAttributes={setAttributes} />
          <HeadingTagControl level={attributes.showLevelAs} setAttributes={setAttributes} attribute='showLevelAs' />
        </ToolbarGroup>
      </BlockControls>

      <CombinedNotices notices={locks} />

      <section className={_CLASSES.root}>

        <RichText
          identifier="content"
          tagName={`h${attributes.level}`}
          value={attributes.content}
          className={_CLASSES.heading}
          allowedFormats={['core/language']}
          placeholder={_x( 'Enter your heading…', 'Placeholder', 'jabp' )}
          onChange={(content) => {
            // Remove `<meta charset="utf-8">` from copy-and-paste actions.
            if (content.includes( '<meta charset="utf-8">' )) {
              content = content.replace( /<meta charSet="utf-8">/gmi, '' ).trim()
            }
            setAttributes( {content} );
          }}
          onMerge={mergeBlocks}
          onSplit={(content, isOriginal) => {
            let block;

            if (isOriginal || content) {
              block = createBlock( name, {
                ...attributes,
                content,
              } );
            } else {
              block = createBlock( getDefaultBlockName() ?? name );
            }

            if (isOriginal) {
              block.clientId = clientId;
            }

            return block;
          }}
          onReplace={onReplace}
          onRemove={() => onReplace( [] )}
          {...(Platform.isNative && {deleteEnter: true})}
        />

        <button className={_CLASSES.button} onClick={event => event.preventDefault()}>
          {memoizedIcons[0]}
          <span dangerouslySetInnerHTML={{__html: __( 'Yes', 'jabp' )}} />
        </button>

        <button className={_CLASSES.button} onClick={event => event.preventDefault()}>
          {memoizedIcons[1]}
          <span dangerouslySetInnerHTML={{__html: __( 'No', 'jabp' )}} />
        </button>
      </section>
    </>
  );
}
