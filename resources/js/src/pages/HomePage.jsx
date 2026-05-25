import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { FileText } from 'lucide-react';
import SubjectAreaCard from '../components/SubjectAreaCard';
import ArticleCard from '../components/ArticleCard';

import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';
import axios from 'axios';
import { BASEURL } from '../App';
const truncateText = (text, wordLimit = 100) => {
  const words = text.split(' ');
  if (words.length > wordLimit) {
    return words.slice(0, wordLimit).join(' ') + '...'; // Add "..." to indicate truncation
  }
  return text;
};

const HomePage = () => {
  const [articles,setArticles] = useState([]);
  const [banners,setBanners] = useState([]);
  const [subjects,setSubjects] = useState([]);
  const loadArticles = ()=>{
    axios.get(BASEURL+'last_articles').then(response =>response.data).then((response_data)=>{
        let articles = response_data.data;
        setArticles(articles);
    })
  }
  const loadSubjects = ()=>{
    axios.get(BASEURL+'latest_subjects').then(response =>response.data).then((response_data)=>{
        let subjects = response_data.data;
        setSubjects(subjects);
    })
  }
  const loadBanners = ()=>{
    axios.get(BASEURL+'front_banners').then(response =>response.data).then((response_data)=>{
        let banners = response_data.data;
        setBanners(banners);
    })
  }
  useEffect(()=>{
    loadBanners();
    loadSubjects();
    loadArticles();
  },[])

  const subjectColor = [{ bg: 'bg-blue-100', text: 'text-blue-800' },{ bg: 'bg-green-100', text: 'text-green-800' },{ bg: 'bg-purple-100', text: 'text-purple-800' },{ bg: 'bg-indigo-100', text: 'text-indigo-800' },{ bg: 'bg-rose-100', text: 'text-rose-800' }];

  const featuredArticles = articles.filter(article => article.isFeatured);


  return (
    <div>
      {/* Hero Section with Slider */}
      <section className="-mt-8 mb-12 h-[400px]">
        <div className="max-w-6xl mx-auto">
           <Swiper
            modules={[Autoplay, Pagination]}
            spaceBetween={0}
            slidesPerView={1}
            autoplay={{ delay: 5000, disableOnInteraction: false  }}
            pagination={{ clickable: true }}
            className="rounded-xl overflow-hidden shadow-lg"
          >
            {banners.map((banner) => (
              <SwiperSlide key={banner.id} className='p-4 bg-slide bg-gradient-to-r from-[#172858] to-[#192d6a]'>
                <div className="relative bg-gradient-to-r from-primary-900 to-primary-800 h-[400px] flex items-center">
                
                  <div className="relative z-10 px-8 md:px-16 max-w-3xl mb-8">
                   
                    <h2 className="text-3xl font-serif font-bold text-white mb-4">
                     <span className="block md:hidden">
                        {truncateText(banner.title, 3)}
                      </span>
                       <span className="hidden md:block">
                          {truncateText(banner.title,10)}
                        </span>
                    </h2>
                    <p className="text-primary-100 mb-6 line-clamp-2 block md:hidden" dangerouslySetInnerHTML={{ __html: truncateText(banner?.description,5) }}>
                    </p>
                    <p className="text-primary-100 mb-6 line-clamp-2 hidden md:block" dangerouslySetInnerHTML={{ __html: truncateText(banner?.description,10) }}>
                    </p>
                    <Link
                      to={`${banner.link}`}
                      className="inline-flex items-center px-6 py-3 bg-white text-primary-800 font-medium rounded-md hover:bg-primary-50 transition-colors duration-200"
                    >
                      {banner.button_name}
                    </Link>
                  </div>
                </div>
              </SwiperSlide>
            ))}
          </Swiper>
        </div>
      </section>
       {/* Subject Areas Section */}
      <section className="py-5 bg-gray-50 rounded-lg my-10">
        <div className="max-w-6xl mx-auto px-4">
          <div className="flex justify-between items-baseline mb-8">
            <h2 className="font-serif text-2xl md:text-3xl font-semibold text-gray-900">
              Subject Areas
            </h2>
            <Link 
              to="/gateways" 
              className="text-sm font-medium text-primary-700 hover:text-primary-800 transition-colors"
            >
              View all subject areas →
            </Link>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {subjects.map((subject) => (
              
              <SubjectAreaCard key={subject.id} subjectarea={subject} />
            ))}
          </div>
        </div>
      </section>

      {/* Featured Articles Section */}
      {articles.length > 0 && (
      <section className="py-10">
        <div className="max-w-6xl mx-auto px-4">
          <div className="flex justify-between items-baseline mb-8">
            <h2 className="font-serif text-2xl md:text-3xl font-semibold text-gray-900">
              Featured Articles
            </h2>
            <Link 
              to="/articlespage?featured=true" 
              className="text-sm font-medium text-primary-700 hover:text-primary-800 transition-colors"
            >
              View all featured articles →
            </Link>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {articles.map((article) => (
              <ArticleCard key={article.id} article={article} />
            ))}
          </div>
        </div>
      </section>
      )}

      {/* Call to Action Section */}
      <div className='max-w-6xl mx-auto'>
      <section className="py-10 md:py-16 my-10 bg-primary-800 text-white rounded-lg ">
        <div className="max-w-4xl mx-auto px-4 text-center">
          <h2 className="font-serif text-2xl md:text-3xl font-semibold mb-4">
            Ready to Publish Your Research?
          </h2>
          <p className="text-primary-100 mb-8 max-w-2xl mx-auto">
            We welcome submissions from researchers across all disciplines. Our peer-review process ensures the highest quality standards for published articles.
          </p>
          <Link
            to="/submit"
            className="inline-flex items-center justify-center px-6 py-3 bg-white text-primary-800 font-medium rounded-md shadow-sm hover:bg-gray-100 transition-colors duration-200"
          >
            <FileText className="h-5 w-5 mr-2" />
            Submit Your Manuscript
          </Link>
        </div>
      </section>
      </div>
    </div>
  );
};

export default HomePage;