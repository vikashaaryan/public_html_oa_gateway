import React, { useState, useEffect, useRef } from 'react';
import { useSearchParams } from 'react-router-dom';
import ArticleCard from '../components/ArticleCard';
import { Search, Filter, X } from 'lucide-react';
import axios from 'axios';
import { BASEURL } from '../App';

const SearchArticlePage = () => {
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
    
    var subjectParam = searchParams.get('subject');
    var universityParam = searchParams.get('university');
    var topicParam = searchParams.get('topic')?searchParams.get('topic'):'';
    var articletypeParam = searchParams.get('article_type')?searchParams.get('article_type'):'';
    if (subjectParam ){ 
      setSelectedSubject(subjectParam);
    }
    else{
      setSelectedSubject('');
    }
    if (universityParam) {
      setSelectedUniversity(universityParam);
    }
    else{
      setSelectedUniversity('');
    }
    if (articletypeParam) {
      setSelectedArticleType(articletypeParam);
    }
    else{
      setSelectedArticleType('');
    }
    var searchparam = searchParams.get('search')?searchParams.get('search'):'';
    axios.get(BASEURL+'front_articles?subject='+subjectParam+'&university='+universityParam+'&topic='+topicParam+'&article_type='+articletypeParam+'&search='+searchparam).then(response=>response.data).then((response_data)=>{
        let articles = response_data.data;
        setArticles(articles);
    })
  };

  //

  return (
    <div className="max-w-6xl mx-auto">
      <h1 className="font-serif text-3xl md:text-4xl font-bold text-gray-900 mb-4">
        Articles
      </h1>
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

export default SearchArticlePage;