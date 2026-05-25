import React, { useState, useEffect, useRef } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';
import { BASEURL } from '../App';

const StaticPage = () => {
const hash = window.location.hash; // "#contact_us"
const slug = hash.replace('#', '');
  const [page,SetPage] = useState([]);
  const loadPage = () =>{
    axios.get(BASEURL+'front_pages/'+slug).then(response=>response.data).then(response_data=>{
          let page = response_data.data;
          SetPage(page);
      })
  }


useEffect(() => {
  loadPage();
}, []);


  if (!page) {
    return (
      <div className="text-center py-16">
        <h2 className="text-2xl font-semibold text-gray-900 mb-4">Page Not Found</h2>
        <p className="text-gray-600 mb-8">The Page you're looking for doesn't exist or has been removed.</p>
        <Link 
          to="/"
          className="inline-flex items-center justify-center px-4 py-2 bg-primary-700 text-white font-medium rounded-md hover:bg-primary-800 transition-colors"
        >
          Return Home
        </Link>
      </div>
    );
  }

  return (
    <div className="">

      <Link 
        to={`/`}  
        className="inline-flex items-center text-sm text-gray-600 hover:text-primary-700 mb-6 transition-colors"
      >
        <h3>Return Home</h3>
      </Link>

      {/* Article Header */}
      <div className="swiper-slide1  rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div className="p-6 md:p-8">
          
          <h1 className="font-serif text-3xl font-bold text-white mb-4">
            {page.name}
          </h1>
          
          
        </div>
      </div>

      {/* University Content with Index Sidebar */}
      <div className="flex flex-col md:flex-row gap-8">
       

        {/* University Content */}
        <div className="flex-1 bg-white rounded-lg shadow-sm border border-gray-100 p-6 md:p-8">
          {/* For demonstration, we'll create sample content for each section */}
          <section  className="mb-8">
            <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-4">{page.name}</h2>
            <p className="text-gray-700 leading-relaxed"  dangerouslySetInnerHTML={{ __html: page.description }}>
            </p>
          </section>
          
        </div>
      </div>
    </div>
  );
};

export default StaticPage;