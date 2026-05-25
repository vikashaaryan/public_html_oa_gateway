import React from 'react';
import { Link } from 'react-router-dom';
import { BookOpen } from 'lucide-react';
const truncateText = (text, wordLimit = 100) => {
  const words = text.split(' ');
  if (words.length > wordLimit) {
    return words.slice(0, wordLimit).join(' ') + '...'; // Add "..." to indicate truncation
  }
  return text;
};

const SubjectAreaCard = ({ subjectarea }) => {
  return (
    <div className="bg-white rounded-lg shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md">
      <div className="p-6">
        <div className="flex items-start justify-between mb-4">
          <h3 className="font-serif text-xl font-semibold text-gray-900">
            {subjectarea.name}
          </h3>
          <div className="text-primary-700">
            <BookOpen className="h-5 w-5" />
          </div>
        </div>
        <p className="text-gray-600 mb-4 text-sm">
          {truncateText(subjectarea.description, 20)}
        </p>
        <div className="flex justify-between items-center">
          <span className="text-sm text-gray-500">
            {subjectarea.article_count} articles
          </span>
          <Link 
            to={`/subject/${subjectarea.slug_url}`}
            className="text-sm font-medium text-primary-700 hover:text-primary-800 transition-colors"
          >
            Browse articles →
          </Link>
        </div>
      </div>
    </div>
  );
};

export default SubjectAreaCard;