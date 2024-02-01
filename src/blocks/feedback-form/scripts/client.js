window.addEventListener( 'DOMContentLoaded', () => Array.from( document.getElementsByClassName( 'jabp-feedback-form' ) )?.forEach( f => Array.from( f.getElementsByTagName( 'button' ) )?.forEach( b => b.onclick = () => makeApiRequest( f, b.dataset.direction ) ) ) );

const makeApiRequest = async (section, direction) => {
  if( ! section || ! direction ) {
    return;
  }

  const {nonce, endpoint, post_id} = window?.jabp_feedback_form;

  // Data to be sent in the POST request.
  const params = new URLSearchParams( {
    action: 'feedback_form',
    post_id,
    direction,
    _ajax_nonce: nonce
  } );

  // Create an AbortController instance to potentially cancel the request.
  const controller = new AbortController();
  const {signal} = controller;

  // Options for the fetch call, including the nonce, method, and signal.
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;charset=utf-8',
      'X-WP-Nonce': nonce
    },
    signal, // Include the signal for potential cancellation.
  };

  try {
    // Make the POST request using fetch
    const response = await fetch( `${endpoint}?${params.toString()}`, options );

    // Check if the request was aborted
    if (signal.aborted) {
      console.log( 'Request aborted' );
      return;
    }

    if (!response.ok) {
      throw new Error( response.statusText );
    }
    // Parse the response JSON
    const responseData = await response.json();

    if( responseData?.success ) {

      const {heading, message, direction} = responseData.data;

      section.classList.add( `jabp-feedback-form--${direction}` );
      Array.from(section.getElementsByTagName( 'button' ))?.forEach( btn => btn.setAttribute( 'disabled', 'disabled' ) );

      const headingEl = section.querySelector( '.jabp-feedback-form__heading' );
      if (headingEl) {
        headingEl.innerHTML = heading;

        const paragraphEl = document.createElement( 'p' );
        paragraphEl.classList.add( 'jabp-feedback-form__message' );
        paragraphEl.textContent = message;

        if (headingEl.parentNode) {
          headingEl.parentNode.insertBefore( paragraphEl, headingEl.nextSibling );
        }
      }

      setCookie( section.id, direction, 365 );
    }
  } catch (error) {
    // Check if the error is due to an aborted request
    if (error.name === 'AbortError') {
      console.error( 'Request aborted' );
    } else {
      console.error( 'Error:', error );
    }
  }
};



// Function to set a cookie
const setCookie = (name, value, daysToExpire) => {
  const expirationDate = new Date();
  expirationDate.setDate(expirationDate.getDate() + daysToExpire);

  document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expirationDate.toUTCString()}; path=/`;
}
