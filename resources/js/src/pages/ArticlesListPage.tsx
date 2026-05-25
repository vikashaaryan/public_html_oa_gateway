import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import ArticleCard from '../components/ArticleCard';
import { Calendar } from 'lucide-react';
import axios from 'axios';
import { BASEURL } from '../App';

const ArticlesListPage = () => {
  const [allarticles, setAllArticles] = useState([]);
  const [issues, setIssues] = useState([]);
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);

  // Function to load articles
  const loadArticles = (pageNumber = 1) => {
    axios
      .get(`${BASEURL}front_article_list/`, { params: { page: pageNumber } })
      .then((response) => {
        const responseData = response.data;
        setAllArticles(responseData.data);
        setIssues(responseData.issues);
        setPagination(responseData.pagination); // Set pagination data from response
      })
      .catch((error) => {
        console.error('Error loading articles:', error);
      });
  };

  // Run when the component mounts or currentPage changes
  useEffect(() => {
    console.log(currentPage);
  loadArticles(currentPage);
  window.scrollTo(0, 0); // Optional: Scroll to top on pagination
}, [currentPage]);

  if (!allarticles ) {
    return (
      <div className="text-center py-16">
        <h2 className="text-2xl font-semibold text-gray-900 mb-4">Issue Not Found</h2>
        <p className="text-gray-600 mb-8">No Articles Found.</p>
        <Link
          to="/"
          className="inline-flex items-center justify-center px-4 py-2 bg-primary-700 text-white font-medium rounded-md hover:bg-primary-800 transition-colors"
        >
          Back to Home
        </Link>
      </div>
    );
  }

  // Format date
  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
    });
  };

  return (
    <div>
    <div className="max-w-6xl mx-auto md:flex lg:flex">
      <div className="lg:w-3/4 md:w-3/4 w-full">
        {/* Articles List */}
        <section>
          <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
            Articles
          </h2>

          {allarticles.length > 0 ? (
            <div className="space-y-8">
              {allarticles.map((article, index) => (
                <ArticleCard key={index} article={article} />
              ))}
            </div>
          ) : (
            <div className="text-center py-10 bg-gray-50 rounded-lg">
              {/* <p className="text-gray-600">No articles have been published in this issue yet.</p> */}
            </div>
          )}
        </section>
      </div>

      {/* Issue List Sidebar */}
      <div className=" lg:w-[40%] w-full md:ml-8 md:w-[40%]">
        {issues.length > 0 && (
          <div className="sticky top-24" >
             <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">Archives</h2>
             <div
        className="bg-white rounded-lg shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md p-4 max-h-[600px] overflow-y-auto">
              
              {issues.map((issue1, index1) => (
                <div className="font-serif text-2xl text-gray-900 pb-2 p-2" key={index1}>
                  <Link to={`/archive/${issue1?.volume?.id}/${issue1?.id}`}>
                    {issue1?.volume?.name} <span className="mx-2">→</span> {issue1.name}
                  </Link>
                </div>
              ))}
            </div>
          </div>
        )}
      </div>
    </div>

    <div className="flex justify-between mt-8 w-100">
      <button
        onClick={() => setCurrentPage(currentPage - 1)}
        disabled={currentPage === 1}
        className="px-4 py-2 bg-primary-700 text-white rounded-md disabled:bg-gray-300"
      >
        Previous
      </button>
      <span>
        Page {currentPage} of {pagination?.last_page}
      </span>
      <button
        onClick={() => setCurrentPage((prev) => prev + 1)}
  disabled={currentPage === pagination?.last_page}
        className="px-4 py-2 bg-primary-700 text-white rounded-md disabled:bg-gray-300"
      >
        Next
      </button>
    </div>
    </div>
  );
};

export default ArticlesListPage;
