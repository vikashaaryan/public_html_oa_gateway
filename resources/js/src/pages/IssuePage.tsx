import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import ArticleCard from '../components/ArticleCard';
import { Calendar } from 'lucide-react';
import axios from 'axios';

const IssuePage = () => {
  const { volumeId, issueId } = useParams<{ volumeId: string; issueId: string }>();
  
  const [issue,setIssues] = useState([]);
  const [volume,setVolumes] = useState([]);
  const [articles,setArticles] = useState([]);

  const loadissue = () =>{
      axios.get('front_get_issue/'+issueId).then(response => response.data).then((response_data)=>{
        let issue = response_data.data;
        setIssues(issue);
      })
  }
  const loadVolume = () =>{
      axios.get('front_get_volume/'+volumeId).then(response => response.data).then((response_data)=>{
        let volume = response_data.data;
        setVolumes(volume);
      })
  }
  const loadArticles =() =>{
    axios.get('front_archive_articles/'+volumeId+'/'+issueId).then(response => response.data).then((response_data)=>{
        let articles = response_data.data;
        setArticles(articles);
      })
  }
  useEffect(()=>{
    loadissue();
    loadVolume();
    loadArticles();
  }, [volumeId, issueId])

  if (!volume || !issue) {
    return (
      <div className="text-center py-16">
        <h2 className="text-2xl font-semibold text-gray-900 mb-4">Issue Not Found</h2>
        <p className="text-gray-600 mb-8">The issue you're looking for doesn't exist or has been removed.</p>
        <Link 
          to="/archive"
          className="inline-flex items-center justify-center px-4 py-2 bg-primary-700 text-white font-medium rounded-md hover:bg-primary-800 transition-colors"
        >
          Return to Archive
        </Link>
      </div>
    );
  }

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long'
    });
  };


  return (
    <div className="max-w-6xl mx-auto">
      <Link 
        to="/articlespage" 
        className="inline-flex items-center text-sm text-gray-600 hover:text-primary-700 mb-6 transition-colors"
      >
        ← Back to Articles
      </Link>

      {/* Issue Header */}
      <div className="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div className="p-6 md:p-8">
          <div className="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <Calendar className="h-4 w-4" />
            <span>{formatDate(issue.publish_date)}</span>
            <span className="text-gray-300">|</span>
            <span>{volume.name}, {issue.name}</span>
          </div>
          
          <h1 className="font-serif text-3xl font-bold text-gray-900 mb-4">
            {issue.title}
          </h1>
          
          {issue.description && (
            <p className="text-gray-600">
              {issue.description}
            </p>
          )}
        </div>
      </div>

      {/* Articles List */}
      <section>
        <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Articles in this Issue
        </h2>
        
        {issue.article_count > 0 ? (
          <div className="space-y-8">
              {articles.map((article,index) => (
                <ArticleCard key={index} article={article} />
              ))}
          </div>
        ) : (
          <div className="text-center py-10 bg-gray-50 rounded-lg">
            <p className="text-gray-600">No articles have been published in this issue yet.</p>
          </div>
        )}
      </section>

      {/* Issue Information */}
      <section className="mt-12 bg-gray-50 rounded-lg p-6">
        <h2 className="font-serif text-xl font-semibold text-gray-900 mb-4">
          Subcategory Information
        </h2>
        <div className="space-y-2 text-sm text-gray-600">
          <p>
            <strong>Published:</strong> {formatDate(issue.publish_date)}
          </p>
          <p>
            <strong>Volume:</strong> {volume.name}
          </p>
          <p>
            <strong>Subcategory:</strong> {issue.name}
          </p>
          <p>
            <strong>Articles:</strong> {issue.article_count}
          </p>
        </div>
      </section>
    </div>
  );
};

export default IssuePage;