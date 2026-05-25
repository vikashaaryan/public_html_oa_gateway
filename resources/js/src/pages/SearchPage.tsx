import React, { useState, useEffect, useRef } from 'react';
import { useSearchParams } from 'react-router-dom';
import ArticleCard from '../components/ArticleCard';
import { Search, Filter, X } from 'lucide-react';
import axios from 'axios';
import { BASEURL } from '../App';

const SearchPage = () => {
  const [searchTerm, setSearchTerm] = useState<string>('');
  const [isFiltersOpen, setIsFiltersOpen] = useState<boolean>(false);

  const [articles,setArticles] = useState([]);
  const [subjects,setSubjects] = useState([]);
  const [articleTypes,setarticleTypes] = useState([]);
  const [universities,setUniversities] = useState([]);
  const [searchParams, setSearchParams] = useSearchParams();
  const [selectedSubject, setSelectedSubject] = useState<number>();
  const [selectedUniversity, setSelectedUniversity] = useState<number>();
  const [selectedArticleType, setSelectedArticleType] = useState<number>();

  const subjectRef = useRef(null);
  const universitRef = useRef(null);
  const articletypeRef = useRef(null);
  // Initialize state from URL parameters
  useEffect(() => {
    const subjectParam = searchParams.get('subject');
    const universityParam = searchParams.get('university');
    const articleTypeParam = searchParams.get('article_type');
    if (subjectParam) setSelectedSubject(subjectParam);
    if (universityParam) setSelectedUniversity(universityParam);
    if (articleTypeParam) setSelectedArticleType(articleTypeParam);
   
    
    loadSubjects();
    loadUniversities();
    loadArticleTypes();
    performSearch();
  }, [searchParams]);

  // Update search results based on filters
  
  const loadSubjects = ()=>{
    axios.get(BASEURL+'latest_subjects').then(response =>response.data).then((response_data)=>{
        let subjects = response_data.data;
        setSubjects(subjects);
    })
  }

  const loadArticleTypes = ()=>{
    axios.get(BASEURL+'front_article_types').then(response =>response.data).then((response_data)=>{
        let article_types = response_data.data;
        setarticleTypes(article_types);
    })
  }

  const loadUniversities = ()=>{
    axios.get(BASEURL+'front_universities').then(response =>response.data).then((response_data)=>{
        let universities = response_data.data;
        setUniversities(universities);
    })
  }
  const updateSearchParams = () => {
    const params = new URLSearchParams();

    if (searchTerm) params.set('search', searchTerm);
    if (selectedSubject) params.set('subject', selectedSubject);
    if (selectedUniversity) params.set('university', selectedUniversity);
    if (selectedArticleType) params.set('article_type', selectedArticleType);
    setSearchParams(params);
  };
  const resetFilters = () => {
    setSearchTerm('');
    setSelectedSubject('');
    setSelectedUniversity('');
    setSelectedArticleType('');
    setSearchParams({});
  };
  const handleSearch = () => {
    updateSearchParams();
    performSearch();
  };

  // Toggle mobile filters
  const toggleFilters = () => {
    setIsFiltersOpen(!isFiltersOpen);
  };
  const handleevent = () =>{
      let subjectselectedvalue = subjectRef.current.value;
      let universityselectedvalue = universitRef.current.value;
      let articletypeselectedvalue = articletypeRef.current.value;
      setSelectedSubject(subjectselectedvalue);
      setSelectedUniversity(universityselectedvalue);
      setSelectedArticleType(articletypeselectedvalue);

      performSearch();
  }

  const performSearch = () => {
    let subjectselectedvalue    = subjectRef.current.value;
    let universityselectedvalue = universitRef.current.value;
    let articletypeselectedvalue = articletypeRef.current.value;
    var subjectParam = searchParams.get('subject');
    var universityParam = searchParams.get('university');
    var topicParam = searchParams.get('topic')?searchParams.get('topic'):'';
    var articletypeParam = searchParams.get('article_type')?searchParams.get('article_type'):'';
    if (subjectParam ){ 
      subjectselectedvalue = subjectParam;
      setSelectedSubject(subjectParam);
    }
    else if(subjectselectedvalue){
      subjectselectedvalue = subjectselectedvalue;
      setSelectedSubject(subjectselectedvalue);
    }
    else{
      setSelectedSubject('');
    }
    if (universityParam) {
      universityselectedvalue = universityParam;
      setSelectedUniversity(universityParam);
    }
    else if(universityselectedvalue){
      universityselectedvalue = universityselectedvalue;
      setSelectedUniversity(universityselectedvalue);
    }
    else{
      setSelectedUniversity('');
    }
    if (articletypeParam) {
      articletypeselectedvalue = articletypeParam;
      setSelectedArticleType(articletypeParam);
    }
    else if(articletypeselectedvalue){
      articletypeselectedvalue = articletypeselectedvalue;
      setSelectedArticleType(articletypeselectedvalue);
    }
    else{
      setSelectedArticleType('');
    }
    var searchparam = searchParams.get('search')?searchParams.get('search'):'';
    axios.get(BASEURL+'front_articles?subject='+subjectselectedvalue+'&university='+universityselectedvalue+'&topic='+topicParam+'&article_type='+articletypeselectedvalue+'&search='+searchparam).then(response=>response.data).then((response_data)=>{
        let articles = response_data.data;
        setArticles(articles);
    })
  };

  //

  return (
    <div className="max-w-6xl mx-auto">
      <h1 className="font-serif text-3xl md:text-4xl font-bold text-gray-900 mb-4">
        Search Articles
      </h1>
      <p className="text-lg text-gray-600 mb-8">
        Search for articles by title, subject area, university, article type
      </p>

      {/* Search and Filters */}
      <div className="mb-10">
       
       <div className="flex flex-col lg:flex-row gap-4 mb-6">
          {/* Search Input */}
          <div className="flex-1">
            <div className="relative">
              <input
                type="text"
                placeholder="Search by title"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50"
                onKeyDown={(e) => e.key === 'Enter' && handleSearch()}
              />
              <Search className="absolute left-3 top-2.5 h-5 w-5 text-gray-400" onclick={handleevent} />
            </div>
          </div>

          {/* Filter Toggle for Mobile */}
          <button 
            onClick={toggleFilters}
            className="lg:hidden flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
          >
            <Filter className="h-5 w-5 mr-2 text-gray-600" />
            <span>Filters</span>
          </button>

          {/* Desktop action buttons */}
          <div className="hidden lg:flex space-x-3">
            <button 
              onClick={handleSearch}
              className="px-6 py-2 bg-primary-700 text-white font-medium rounded-md shadow-sm hover:bg-primary-800 transition-colors"
            >
              Search
            </button>
            <button 
              onClick={resetFilters}
              className="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-md shadow-sm hover:bg-gray-50 transition-colors"
            >
              Reset Filters
            </button>
          </div>
        </div>
      

        {/* Filters - Desktop version is always visible, mobile version is toggleable */}
        <div className={`bg-white rounded-lg shadow-sm border border-gray-100 p-6 ${isFiltersOpen || 'hidden lg:block'}`}>
          {/* Mobile close button */}
          <div className="lg:hidden flex justify-between items-center mb-4">
            <h3 className="font-medium text-gray-900">Filters</h3>
            <button onClick={toggleFilters}>
              <X className="h-5 w-5 text-gray-500" />
            </button>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {/* Subject Area Filter */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Subject Area
              </label>
              <select ref={subjectRef}
                value={selectedSubject}
                onChange={(e) => setSelectedSubject(e.target.value)}
                className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50"
              >
                <option value="">All Subject Areas</option>
                {subjects.map((subject) => (
                  <option key={subject.id} value={subject.id}>
                    {subject.name}
                  </option>
                ))}
              </select>
            </div>

            {/* University Filter */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                University
              </label>
              <select ref={universitRef}
                value={selectedUniversity}
                onChange={(e) => setSelectedUniversity(e.target.value)}
                className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50"
              >
                <option value="">All Universities</option>
                {universities.map((university) => (
                  <option key={university.id} value={university.id}>
                    {university.name}
                  </option>
                ))}
              </select>
            </div>
            {/* University Filter */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Article Types
              </label>
              <select ref={articletypeRef}
                value={selectedArticleType}
                onChange={(e) => setSelectedArticleType(e.target.value)}
                className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50"
              >
                <option value="">All Article Types</option>
                {articleTypes.map((article_type) => (
                  <option key={article_type.id} value={article_type.id}>
                    {article_type.name}
                  </option>
                ))}
              </select>
            </div>
            {/* Mobile action buttons */}
          <div className="mt-6 flex space-x-3 lg:hidden">
            <button 
              onClick={() => {
                handleevent();
                toggleFilters();
              }}
              className="flex-1 px-4 py-2 bg-primary-700 text-white font-medium rounded-md shadow-sm hover:bg-primary-800 transition-colors"
            >
              Apply Filters
            </button>
            <button 
              onClick={resetFilters}
              className="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-md shadow-sm hover:bg-gray-50 transition-colors"
            >
              Reset
            </button>
          </div>
            
          </div>
          
          
        </div>
     
      </div>
      {/* Results Section */}
      <div className="mb-8">
        <div className="flex justify-between items-baseline mb-6">
          <h2 className="font-serif text-2xl font-semibold text-gray-900">
            {articles.length === 0 ? "No Results Found" : 
             (articles.length === 1 ? "1 Result Found" : `${articles.length} Results Found`)}
          </h2>
        </div>

        {/* Articles Grid */}
        {articles.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {articles.map((article) => (
              <ArticleCard key={article.id} article={article} />
            ))}
          </div>
        ) : (
          <div className="text-center py-10 bg-gray-50 rounded-lg">
            <p className="text-gray-600 mb-4">No articles matching your search criteria.</p>
           
          </div>
        )}
      </div>
    </div>
  );
};

export default SearchPage;