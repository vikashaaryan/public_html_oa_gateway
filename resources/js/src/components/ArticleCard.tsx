import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { Article } from '../types';
import { Calendar, User, Tag } from 'lucide-react';
import axios from 'axios';
interface ArticleCardProps {
  article: Article;
}

const ArticleCard = ({ article }) => {
  const [showAuthorInfo, setShowAuthorInfo] = useState<string | null>(null);

  // Format date to be more readable
  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }).format(date);
  };

 

  const subjectColor = [{ bg: 'bg-blue-100', text: 'text-blue-800' },{ bg: 'bg-green-100', text: 'text-green-800' },{ bg: 'bg-purple-100', text: 'text-purple-800' },{ bg: 'bg-indigo-100', text: 'text-indigo-800' },{ bg: 'bg-rose-100', text: 'text-rose-800' }];

  
  return (
    <div className="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md mb-3">
      <div className="p-6">
        <div className="flex flex-wrap gap-2 mb-3">
          {article.subjects.map((subject, index) => {
            const color = subjectColor[index % subjectColor.length];
             return (
             <span className={`inline-block px-2 py-1 text-xs font-medium rounded ${color.bg} ${color.text}`}>
              {subject.name ? subject.name :''}
            </span>
            );
          })}
        </div>
        
        <Link to={`/article/${article.slug_url}`}>
          <h3 className="font-serif text-xl font-semibold text-gray-900 mb-2 hover:text-primary-700 transition-colors">
            {article.title}
          </h3>
          
        </Link>
        
        <div className=" items-center text-sm text-gray-500 mb-3 ">
           <div className="flex items-center relative mb-3">
            <User className="h-4 w-4 mr-1" />
            <div className="flex flex-wrap gap-x-2">
                {article.article_authors.map((author, index) => (
                <span
                  key={author}
                  className="relative group cursor-pointer"
                  onMouseEnter={() => setShowAuthorInfo(author)}
                  onMouseLeave={() => setShowAuthorInfo(null)}
                >
                  {author.author_name}
                  {index < article.article_authors.length - 1 ? "," : ""}
                  
                  {showAuthorInfo === author  && (
                    <div className="absolute z-50 left-0 top-full mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 p-4">
                      <div className="text-gray-700 text-sm">{author.author_name}</div>
                      <div className="text-gray-600 text-sm">{author.about_author}</div>
                    </div>
                  )}
                </span>
              ))}
            </div>
          </div>
          <div className="flex items-center mb-3">
            <Calendar className="h-4 w-4 mr-1" />
            <span>{formatDate(article.publish_date)}</span>
          </div>
          
         
        </div>
        <h5 className='mb-3'>{article.article_id}</h5>
        
        <p className="text-gray-600 mb-4 text-sm line-clamp-3">
          {article.topic && article.topic.name?article.topic.name:''}
        </p>
        
        <div className="flex justify-between items-center mt-4">
          
          
          <Link 
            to={`/article/${article.slug_url}`}
            className="text-sm font-medium text-primary-700 hover:text-primary-800 transition-colors"
          >
            Read article →
          </Link>
        </div>
      </div>
    </div>
  );
};

export default ArticleCard;