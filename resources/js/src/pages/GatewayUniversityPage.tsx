import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { Microscope, GraduationCap, Tag } from 'lucide-react';
import axios from 'axios';
import { BASEURL } from '../App';

const GatewayPage: React.FC = () => {
  const [Allsubjects,setSubjects] = useState([]);
  const [AllUniversities,setUniversities] = useState([]);
  const [AllTopics,setTopics] = useState([]);

  const loadSubjects = ()=>{
      axios.get(BASEURL+'front_subjects').then(response =>response.data).then((response_data)=>{
          let subjects = response_data.data;
          setSubjects(subjects);
      })
    }

    const loadTopics = ()=>{
      axios.get(BASEURL+'front_topics').then(response =>response.data).then((response_data)=>{
          let topics = response_data.data;
          setTopics(topics);
      })
    }

  const loadUniversities = ()=>{
      axios.get(BASEURL+'front_universities').then(response =>response.data).then((response_data)=>{
          let universities = response_data.data;
          setUniversities(universities);
      })
    }
   
  const [activeTab, setActiveTab] = useState<TabType>('universities');
     useEffect(()=>{
        loadSubjects();
        loadTopics();
        loadUniversities();
      },[])
  return (
    <div className="max-w-6xl mx-auto">
      <h1 className="font-serif text-3xl md:text-4xl font-bold text-gray-900 mb-4">
        Research Gateways
      </h1>
      <p className="text-lg text-gray-600 mb-8 max-w-3xl">
        Explore research by subject areas, universities, or specific topics. Our gateways provide curated collections of articles and research papers.
      </p>

      {/* Tabs */}
      <div className="flex flex-wrap border-b border-gray-200 mb-8">
        <Link to ='/gateways'
          onClick={() => setActiveTab('subjects')}
          className={`flex items-center px-6 py-3 text-sm font-medium border-b-2 -mb-px ${
            activeTab === 'subjects'
              ? 'text-primary-700 border-primary-700'
              : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300'
          }`}
        >
          <Microscope className="h-5 w-5 mr-2" />
          Subject Areas
        </Link>
        <button
          onClick={() => setActiveTab('universities')}
          className={`flex items-center px-6 py-3 text-sm font-medium border-b-2 -mb-px ${
            activeTab === 'universities'
              ? 'text-primary-700 border-primary-700'
              : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300'
          }`}
        >
          <GraduationCap className="h-5 w-5 mr-2" />
          Universities/Institutions
        </button>
        <Link to='/gatewaystopic'
          className={`flex items-center px-6 py-3 text-sm font-medium border-b-2 -mb-px ${
            activeTab === 'topics'
              ? 'text-primary-700 border-primary-700'
              : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300'
          }`}
        >
          <Tag className="h-5 w-5 mr-2" />
          Topics
        </Link>
      </div>

      {/* Subject Areas Tab */}
      <div className={activeTab === 'subjects' ? 'block' : 'hidden'}>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {Allsubjects.map((area) => (
            <Link
              key={area.id}
              to={`/search?subject=${area.slug_url}`}
              className="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md"
            >
              <div className="p-6">
                <div className="flex items-start justify-between mb-4">
                  <h3 className="font-serif text-xl font-semibold text-gray-900 group-hover:text-primary-700">
                    {area.name}
                  </h3>
                  <div className="text-primary-700">
                    <Microscope className="h-5 w-5" />
                  </div>
                </div>
                <p className="text-gray-600 mb-4 text-sm">
                  {area.description}
                </p>
                <div className="flex justify-between items-center">
                  <span className="text-sm text-gray-500">
                  {area.article_count} articles
                  </span>
                  <span className="text-sm font-medium text-primary-700 group-hover:text-primary-800">
                    Browse articles →
                  </span>
                </div>
              </div>
            </Link>
          ))}
        </div>
      </div>

      {/* Universities Tab */}
      <div className={activeTab === 'universities' ? 'block' : 'hidden'}>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {AllUniversities.map((university) => (
            <Link
              key={university.id}
              to={`/university/${university.slug_url}`}
              className="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md"
            >
              <div className="p-6">
                <div className="flex items-start justify-between mb-4">
                  <h3 className="font-serif text-xl font-semibold text-gray-900 group-hover:text-primary-700">
                    {university.name}
                  </h3>
                  <div className="text-primary-700">
                    <GraduationCap className="h-5 w-5" />
                  </div>
                </div>
                <p className="text-gray-600 mb-4 text-sm">
                  {university.locations.name}
                </p>
                <span className="text-sm font-medium text-primary-700 group-hover:text-primary-800">
                  View research →
                </span>
              </div>
            </Link>
          ))}
        </div>
      </div>

      {/* Topics Tab */}
      <div className={activeTab === 'topics' ? 'block' : 'hidden'}>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {AllTopics.map((topic) => (
            <Link
              key={topic.id}
              to={`/topic/${topic.slug_url}`}
              className="group relative bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md"
            >
              <div className="absolute inset-0">
                
                <div className="absolute inset-0 bg-gradient-to-b from-white/80 to-white"></div>
              </div>
              <div className="relative p-6">
                <h3 className="font-serif text-xl font-semibold text-gray-900 group-hover:text-primary-700 mb-4">
                  {topic.name}
                </h3>
                <span className="text-sm font-medium text-primary-700 group-hover:text-primary-800">
                  Explore research →
                </span>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </div>
  );
};

export default GatewayPage;