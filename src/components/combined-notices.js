import { useMemo } from '@wordpress/element';
import {Notice} from "@wordpress/components";
const CombinedNotices = ({notices}) => {

  return useMemo( () => {
    if (!notices || Object.keys( notices ).length === 0) {
      return;
    }

    return Object.values( notices ).map( ({type, message}) => <Notice status={type} isDismissible={false}>{message}</Notice> );
  }, [ notices ]);
};
export default CombinedNotices;
