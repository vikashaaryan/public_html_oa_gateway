import React, { useState, useEffect, useRef } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';
import { BASEURL } from '../App';
import { Helmet } from 'react-helmet';

const TopicPage = () => {
  const { id }    = useParams<{ id: string }>();
  const [topic,SetTopic] = useState([]);
  const loadTopic = () =>{
      axios.get(BASEURL+'front_get_topic/'+id).then(response=>response.data).then(response_data=>{
          let topic = response_data.data;
          SetTopic(topic);
      })
  }


useEffect(() => {
  loadTopic();
}, []);


  if (!topic) {
    return (
      <div className="text-center py-16">
        <h2 className="text-2xl font-semibold text-gray-900 mb-4">Topic Not Found</h2>
        <p className="text-gray-600 mb-8">The topic you're looking for doesn't exist or has been removed.</p>
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
      {/* Article Header */}
      <div className="swiper-slide1 rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div className="p-6 md:p-8">
          <Helmet>
          <meta name="description" content={ topic?.meta_description } />
          <meta name="title" content={topic?.meta_title } />
          <meta name="keywords" content={topic?.meta_keywords } />
        </Helmet>
          <h1 className="font-serif text-3xl font-bold text-white mb-4">
            {topic.name}
          </h1>
          
          
        </div>
      </div>

      <div className="flex border-b border-gray-200 mb-8">
        <Link 
            to={``} 
            className={`flex items-center px-6 py-3 text-sm font-medium border-b-2 -mb-px ${
                'text-primary-700 border-primary-700 '
              }`}
          >
              <h3>About</h3>
        </Link>
        <Link 
          to={`/searcharticle?topic=${topic.id}`}  
          className={`flex items-center px-6 py-3 text-sm font-medium border-b-2 -mb-px ${
           'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300'
          }`}
        >
          <h3>View Article</h3>
        </Link>
      </div>

      {/* University Content with Index Sidebar */}
      <div className="flex flex-col md:flex-row gap-8">
       

        {/* University Content */}
        <div className="flex-1 bg-white rounded-lg shadow-sm border border-gray-100 p-6 md:p-8">
          {/* For demonstration, we'll create sample content for each section */}
          <section  className="mb-8">
            {/* <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-4">{topic.name}</h2> */}
            <p className="text-gray-700 leading-relaxed"  dangerouslySetInnerHTML={{ __html: topic.description }}>
            </p>
          </section>
          
        </div>
      </div>
    </div>
  );
};

export default TopicPage;