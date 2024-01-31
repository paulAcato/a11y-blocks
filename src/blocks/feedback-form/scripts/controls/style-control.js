import {__, _x, sprintf} from "@wordpress/i18n";
import {ToolbarDropdownMenu} from "@wordpress/components";
import {useMemo} from "@wordpress/element";
import {
  check as checkIcon,
  plus as plusIcon
} from '@wordpress/icons';

/**
 * Controller for the heading level.
 *
 * @param {number} style The style variant.
 * @param {function} setAttributes the WordPress setAttrbiutes function.
 * @return {{}}
 * @constructor
 */
const StyleControl = ({style = 1, setAttributes}) => {
  const thumbIcon = (<svg aria-hidden="true" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M695.559-166.154H300v-430.154l246.462-243.385 15.846 15.231q5.346 5.962 8.827 13.926t3.481 14.591v5.637l-40.308 194h278q23.731 0 42.635 18.904 18.903 18.904 18.903 42.635v48.128q0 5.365-.859 11.716-.859 6.352-2.987 11.387L761.96-208.986q-7.792 18.648-27.145 30.74-19.353 12.092-39.256 12.092Zm-358.636-36.923h359.692q8.462 0 17.308-4.615 8.846-4.616 13.462-15.385l109.538-256.808v-54.884q0-10.77-6.923-17.693-6.923-6.923-17.692-6.923H488.923l45.577-217.23-197.577 195.653v377.885Zm0-377.885v377.885-377.885ZM300-596.308v36.923H163.692v356.308H300v36.923H126.769v-430.154H300Z" /></svg>);

  const icons = [null, thumbIcon, checkIcon, plusIcon];

  const controls = useMemo(() => (
    [
      { label: sprintf( __( 'Heading %s' ), 1), style: 1, icon: thumbIcon },
      { label: sprintf( __( 'Heading %s' ), 2), style: 2, icon: checkIcon},
      { label: sprintf( __( 'Heading %s' ), 3), style: 3, icon: plusIcon},
    ]
  ), []);

  const activeControl = controls.find(control => control.style === style);

  return useMemo(() => (
    <ToolbarDropdownMenu
      label={_x('Select a icon style', 'jabp')}
      icon={activeControl.icon || icons[1]}
      controls={controls.map( control => ({
        ...control,
        isActive: control.style === style,
        onClick: () => setAttributes( {style: control.style} ),
      }) )}
      separator={true}
      isActive={activeControl.style > 1}
    />
  ), [style, controls, activeControl]);
};

export default StyleControl;
