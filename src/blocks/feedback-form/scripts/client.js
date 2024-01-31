import {apiFetch} from '@wordpress/api-fetch';

window.addEventListener( 'DOMContentLoaded', () => {
  const a = Array.from( document.getElementsByClassName( 'jabp-feedback-form' ) );
  a.forEach( (el) => console.log( el ) );

  // makeApiRequest();
} );

const makeApiRequest = async () => {
  // Replace 'your_generated_nonce' with the actual nonce value
  const nonce = 'your_generated_nonce';

  // Define the REST API endpoint
  const endpoint = '/your/custom/endpoint';

  // Data to be sent in the POST request
  const data = {
    key1: 'value1',
    key2: 'value2',
  };

  // Create an AbortController instance to potentially cancel the request
  const controller = new AbortController();
  const { signal } = controller;

  // Options for the fetch call, including the nonce, method, and signal
  const options = {
    method: 'POST',
    body: JSON.stringify(data),
    headers: {
      'Content-Type': 'application/json',
      'X-WP-Nonce': nonce,
    },
    signal, // Include the signal for potential cancellation
  };

  try {
    // Make the POST request using fetch
    const response = await fetch(endpoint, options);

    // Check if the request was aborted
    if (signal.aborted) {
      console.log('Request aborted');
      return;
    }

    // Parse the response JSON
    const responseData = await response.json();

    // Handle the response
    console.log('Response:', responseData);
  } catch (error) {
    // Handle errors
    console.error('Error:', error);

    // Check if the error is due to an aborted request
    if (error.name === 'AbortError') {
      console.log('Request aborted');
    }
  }
};

