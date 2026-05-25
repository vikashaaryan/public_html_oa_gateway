import React, { useEffect } from 'react';

const ShareButtons = () => {
  useEffect(() => {
    // Load the script only if it's not already loaded
    const existingScript = document.querySelector('script[src="https://static.addtoany.com/menu/page.js"]');
    if (!existingScript) {
      const script = document.createElement('script');
      script.src = 'https://static.addtoany.com/menu/page.js';
      script.async = true;
      script.onload = () => {
        // Initialize AddToAny after script loads
        if (window.a2a) window.a2a.init_all();
      };
      document.body.appendChild(script);
    } else {
      // If already loaded, reinitialize
      if (window.a2a) window.a2a.init_all();
    }
  }, []);

  return (
    <div className="a2a_kit a2a_kit_size_32 a2a_default_style">
      <a className="a2a_dd" href="https://www.addtoany.com/share" />
      <a className="a2a_button_email" />
      <a className="a2a_button_whatsapp" />
      <a className="a2a_button_facebook" />
      <a className="a2a_button_linkedin" />
      <a className="a2a_button_x" />
    </div>
  );
};

export default ShareButtons;
