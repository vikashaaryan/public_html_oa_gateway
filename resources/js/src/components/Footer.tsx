import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { BASEURL } from '../App';

const Footer = () => {
  const [footerLinks, setFooterLinks] = useState([]);
  const [setting, setSetting] = useState({});
  const [socialMediaLinks, setSocialMedia] = useState([]);

  const loadFooterLinks = () => {
    axios
      .get(BASEURL + 'front_footers')
      .then((response) => response.data)
      .then((response_data) => {
        let footers = response_data.data;
        setFooterLinks(footers);
      })
      .catch((err) => console.error('Error loading footer links:', err));
  };

  
  const loadSocialMediaLinks = () => {
    axios
      .get(BASEURL + 'front_social_media_links')
      .then((response) => response.data)
      .then((response_data) => {
        let social_media = response_data.data;
        setSocialMedia(social_media);
      })
      .catch((err) => console.error('Error loading footer links:', err));
  };

  const loadSetting = () => {
    axios
      .get(BASEURL + 'front_setting')
      .then((response) => {
        setSetting(response.data.data);
      })
      .catch((err) => console.error('Error loading settings:', err));
  };

  useEffect(() => {
    loadFooterLinks();
    loadSetting();
    loadSocialMediaLinks();
  }, []);

  



  if (!footerLinks.length) {
    return <div>Loading...</div>;
  }

  return (
    <footer className="bg-gray-900 text-gray-300">
      <div className="container mx-auto px-4 py-10 max-w-7xl">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {footerLinks.map((cur_footer, index) => (
            <div key={index}>
              <h3 className="text-white font-serif text-lg font-semibold mb-4">
                {cur_footer.name}
              </h3>
              <ul className="space-y-2 text-sm">
                {cur_footer.links.map((cur_link, index1) => (
                  <li key={index1}>
                    <a
                      href={
                        cur_link.footer_link && cur_link.footer_link.trim() !== ''
                          ? cur_link.footer_link
                          : '/'
                      }
                      className="hover:text-white transition-colors"
                    >
                      {cur_link.name}
                    </a>
                  </li>
                ))}
              </ul>
            </div>
          ))}
          
        </div>
        <div className="flex justify-center gap-4 mt-4">
            {socialMediaLinks.map((social_media,index2)=>{
              return (
                    <div key={index2} className='h-6 w-6 '>
                      <a
                        href={
                          social_media.link && social_media.link.trim() !== ''
                            ? social_media.link
                            : '/'
                        }
                        className="hover:text-white transition-colors"
                       target='_blank'>
                        <img src={`${BASEURL}${social_media.image}`} className="h-6 w-6 rounded-full object-cover mr-4"/>
                      </a>
                    </div>
                  )
            })}
        </div>
        

        {/* Ensure ShareThis buttons are rendered */}
        {/* {isShareScriptLoaded && (
          <div className="sharethis-inline-share-buttons"></div>
        )} */}

        <div className="border-t border-gray-800 mt-8 pt-8 text-sm text-gray-400 text-center">
          <p>&copy; {setting.copy_right}</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
