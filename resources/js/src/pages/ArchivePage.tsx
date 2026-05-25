import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { Calendar, BookOpen } from 'lucide-react';
import axios from 'axios';

const ArchivePage = () => {
  const [volumes,setVolumes] = useState([]);
  const loadVolumes = () =>{
    axios.get('front_archives').then(response=>response.data).then((response_data)=>{
      let volumes = response_data.data;
      setVolumes(volumes);
    })
  }
  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long'
    });
  };
  useEffect(()=>{
    loadVolumes();
  },[])

  return (
    <div className="max-w-6xl mx-auto">
      <h1 className="font-serif text-3xl md:text-4xl font-bold text-gray-900 mb-4">
        Journal Articles
      </h1>
      <p className="text-lg text-gray-600 mb-8">
        Browse all volumes and issues of the International Journal of Advanced Research.
      </p>

      {volumes.map((volume, index) => (
        <div key={index} className="flex">
          <div className="w-3/4" >
          <div className="mb-12">
            <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              {volume.name}
            </h2>
            
            <div className="space-y-4">
                <div 
                  key={volume.issues.id}
                  className="bg-white rounded-lg shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md"
                >
                  <Link 
                    to={`/archive/${volume.id}/${volume.issues.id}`}
                    className="block p-6"
                  >
                    <div className="flex items-start justify-between">
                      <div>
                        <div className="flex items-center gap-2 text-sm text-gray-500 mb-2">
                          <Calendar className="h-4 w-4" />
                          <span>{formatDate(volume.issues.publish_date)}</span>
                          <span className="text-gray-300">|</span>
                          <span>{volume.issues.name}</span>
                        </div>
                        
                        <h3 className="font-serif text-xl font-semibold text-gray-900 mb-2 group-hover:text-primary-700">
                          {volume.issues.title}
                        </h3>
                        
                        {volume.issues.description && (
                          <p className="text-gray-600 text-sm mb-4">
                            {volume.issues.description}
                          </p>
                        )}
                      </div>
                      
                      <div className="flex items-center text-gray-400">
                        <BookOpen className="h-5 w-5" />
                        <span className="ml-2 text-sm">{volume.issues.article_count} articles</span>
                      </div>
                    </div>
                  </Link>
                </div>
            </div>
          </div>
          </div>
          <div className="w-1/4 ms-3 p-3 mt-5">
            <div className='ms-3'>
              <div 
                    className="bg-white rounded-lg shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md"
                  >
                  {volume.all_issues.map((issue1, index1) => (
                    
                      <div className="font-serif text-2xl  text-gray-900 pb-2 p-2" key={index1}>
                        {volume.name} <span className="mx-2" >→</span> {issue1.title}
                      </div>
                    
                  ))}
                </div>
              </div>
            </div>
        </div>
      ))}

      {/* Citation Information */}
      <div className="bg-gray-50 rounded-lg p-6 mt-8">
        <h2 className="font-serif text-xl font-semibold text-gray-900 mb-4">
          How to Cite
        </h2>
        <p className="text-gray-600 text-sm mb-4">
          Articles from the International Journal of Advanced Research should be cited using the following format:
        </p>
        <div className="bg-white p-4 rounded border border-gray-200">
          <p className="text-sm text-gray-700 font-mono">
            Author, A. A., & Author, B. B. (Year). Article Title. International Journal of Advanced Research, Volume(Issue), pp-pp. DOI
          </p>
        </div>
      </div>
    </div>
  );
};

export default ArchivePage;