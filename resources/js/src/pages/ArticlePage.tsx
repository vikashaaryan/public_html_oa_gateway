import React, { useState, useEffect, useRef } from 'react';
import { useParams, Link } from 'react-router-dom';
import { Calendar, User, Tag, FileText, Download, File, ClipboardList,UnlockKeyhole } from 'lucide-react';
import axios from 'axios';
import { BASEURL } from '../App';
import { Helmet } from 'react-helmet';
import ShareButtons from '../components/ShareButtons'
const ArticlePage = () => {
  const subjectColor = [{ bg: 'bg-blue-100', text: 'text-blue-800' },{ bg: 'bg-green-100', text: 'text-green-800' },{ bg: 'bg-purple-100', text: 'text-purple-800' },{ bg: 'bg-indigo-100', text: 'text-indigo-800' },{ bg: 'bg-rose-100', text: 'text-rose-800' }];

  
  const [showAuthorInfo, setShowAuthorInfo] = useState<string | null>(null);
  const { id }    = useParams<{ id: string }>();
  const [article,SetArticle] = useState([]);
  const [activeSection, setActiveSection] = useState<string>('');
  const articleRef = useRef<any>(null);
  const loadArticles = () =>{
      axios.get(BASEURL+'front_get_article/'+id).then(response=>response.data).then(response_data=>{
          let article = response_data.data;
          SetArticle(article);
      console.log(article)
          articleRef.current = article; // Upd
      })
  }

  // Format date to be more readable
  /* const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }).format(date);
  }; */
  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }).format(date);
  };
  // Scroll to section when clicking on index
  const scrollToSection = (sectionId: string) => {
    setActiveSection(sectionId);
    const element = document.getElementById(sectionId);
    if (element) {
      const yOffset = -90; // adjust this to move one line below the top (change based on font size)
    const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;

    window.scrollTo({ top: y, behavior: 'smooth' });
      //element.scrollIntoView({ behavior: 'smooth' });
    }
  };

useEffect(() => {
  loadArticles();
}, []);
  // Update active section based on scroll position
  useEffect(() => {
    
      const handleScroll = () => {
      const contents = articleRef.current?.article_contents || [];
      console.log(article)
      for (let i = contents - 1; i >= 0; i--) {
        const section = document.getElementById(contents[i].id);
        if (section) {
          const rect = section.getBoundingClientRect();
          if (rect.top <= 100) {
            setActiveSection(contents[i].id);
            break;
          }
        }
      }
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  },[]);

  if (!article) {
    return (
      <div className='max-w-6xl mx-auto'>
        <div className="text-center py-16">
          <h2 className="text-2xl font-semibold text-gray-900 mb-4">Article Not Found</h2>
          <p className="text-gray-600 mb-8">The article you're looking for doesn't exist or has been removed.</p>
          <Link 
            to="/"
            className="inline-flex items-center justify-center px-4 py-2 bg-primary-700 text-white font-medium rounded-md hover:bg-primary-800 transition-colors"
          >
            Return Home
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="max-w-6xl mx-auto ">
      <Helmet>
        <meta name="description" content={ article.seo_description } />
        <meta name="title" content={article.seo_title } />
        <meta name="keywords" content={article.seo_keywords } />
      </Helmet>
      <Link 
        to="/articlespage" 
        className="inline-flex items-center text-sm text-gray-600 hover:text-primary-700 mb-6 transition-colors"
      >
        ← Back
      </Link>

      {/* Article Header */}
      <div className="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div className="p-6 md:p-8">
            <div className="flex flex-wrap gap-2 mb-3">
              {Array.isArray(article.subjects) && article.subjects.map((subject, index1) => {
                const color = subjectColor[index1 % subjectColor.length];
                return (
                <span className={`inline-block px-2 py-1 text-xs font-medium rounded ${color.bg} ${color.text}`}>
                  {subject.name ? subject.name :''}
                </span>
                );
              })}
            </div>
            <h1 className="font-serif text-3xl font-bold text-gray-900 mb-4">
              {article.title}
            </h1>
            <div className="flex items-center mb-3">
              <User className="h-4 w-4 mr-1" />
              <span>
                {article?.article_authors?.map((author, index2) => (
                <span
                  key={author}
                  className="relative group cursor-pointer"
                  onMouseEnter={() => setShowAuthorInfo(author)}
                  onMouseLeave={() => setShowAuthorInfo(null)}
                >
                  {author.author_name}
                  {index2 < article.article_authors.length - 1 ? ", " : ""}
                  
                  {showAuthorInfo === author  && (
                    <div className="absolute z-50 left-0 top-full mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 p-4">
                      <div className="text-gray-700 text-sm">{author.author_name}</div>
                      <div className="text-gray-600 text-sm">{author.about_author}</div>
                    </div>
                  )}
                </span>
              ))}
              </span>
            </div>
            <div className=" text-sm text-gray-500 mb-6 gap-x-6 gap-y-2">
            <div className="flex items-center mb-3">
              <Calendar className="h-4 w-4 mr-1" />
              <span>{article?.submit_date ? formatDate(article.submit_date)+', ':''} {article?.approve_date ? formatDate(article.approve_date)+', ':''} {article?.publish_date ? formatDate(article.publish_date)+',':''}</span>
            </div>
            {article.subjects && article.subjects ?  (
            <div className="flex items-center mb-3">
              <File className="h-4 w-4 mr-1"/>
              {article.subjects?.map((cur_subject,index) => (
                <span key={index} className='mr-1'>{cur_subject.name}
                {index < article.subjects.length - 1 ? ', ' : ''}
                </span>
              ))}
            </div>
            ):''}
            {article.doi  ?  (
            <div className="flex items-center mb-3">
              <ClipboardList className="h-4 w-4 mr-1" />
              {article.doi && article.doi_link ? (
                  <a href={article.doi_link} target='_blank'>
                    <span>DOI: {article.doi}</span>
                  </a>
              ):''}
              {article.doi && !article.doi_link ? (
                <span>DOI: {article.doi}</span>
              ):''}
            </div>
            ):''}
            <div className="flex items-center mb-3">
              <Tag className="h-4 w-4 mr-1" />
              <span>{article.article_id?article.article_id:''}</span>
            </div>
            <div className="flex items-center mb-3">
              <UnlockKeyhole className="h-4 w-4 mr-1" />
              <span>{article.article_type && article.article_type.name?article.article_type.name:''}</span>
            </div>
          </div>
          
          <div className="flex flex-wrap gap-2">
            {article.pdf && article.pdf !== "" ? (
            <a href={`${BASEURL}${article.pdf}`} target="_blank" className="inline-flex items-center px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
              <Download className="h-4 w-4 mr-1" />
              PDF
            </a>
            ):null}
            
            {/* <button className="inline-flex items-center px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
              <Share2 className="h-4 w-4 mr-1" />
              Share
            </button>
            <button className="inline-flex items-center px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
              <Bookmark className="h-4 w-4 mr-1" />
              Save
            </button> */}
          </div>
          <div>
        <ShareButtons/>
      </div>
        </div>
      </div>
      

      {/* Article Content with Index Sidebar */}
      <div className="flex flex-col md:flex-row gap-8">
       

        {/* Article Content */}
        <div className="flex-1 bg-white rounded-lg shadow-sm border border-gray-100 p-6 md:p-8">
          {/* For demonstration, we'll create sample content for each section */}
          {article.article_contents?.map((section) => (
          <section id={section.id} key={section.id} className="mb-8">
            <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-4">{section.title}</h2>
            <p className="text-gray-700 leading-relaxed"  dangerouslySetInnerHTML={{ __html: section.description }}>
            </p>
          </section>
          ))}
          
        </div>
         {/* Table of Contents - Sidebar */}
        <div className="md:w-64 flex-shrink-0">
          <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-4 sticky top-24">
            <h2 className="font-serif text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">
              Table of Contents
            </h2>
            <nav>
              <ul className="space-y-2">
                {article.article_contents?.map((section) => (
                  <li key={section.id}>
                    <button
                      onClick={() => scrollToSection(section.id)}
                      className={`text-left w-full px-2 py-1 text-sm rounded transition-colors ${
                        activeSection === section.id
                          ? 'bg-primary-100 text-primary-800 font-medium'
                          : 'text-gray-600 hover:bg-gray-100'
                      }`}
                    >
                      {section.title}
                    </button>
                  </li>
                ))}
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ArticlePage;