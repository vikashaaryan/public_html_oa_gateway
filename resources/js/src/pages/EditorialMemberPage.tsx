import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { Mail, MapPin, GraduationCap, ExternalLink } from 'lucide-react';
import axios from 'axios';
import { BASEURL } from '../App';

const EditorialMemberPage = () => {
  const { id } = useParams<{ id: string }>();
  const [members,setMembers] = useState([]);
  const loadMember = () =>{
      axios.get(BASEURL+'front_get_autor/'+id).then(response=>response.data).then((response_data)=>{
        let members = response_data.data;
        setMembers(members);
      })
  }
  useEffect(()=>{
    loadMember();
  })

  if (!members) {
    return (
      <div className="text-center py-16">
        <h2 className="text-2xl font-semibold text-gray-900 mb-4">Editorial Member Not Found</h2>
        <p className="text-gray-600 mb-8">The editorial member you're looking for doesn't exist or has been removed.</p>
        <Link 
          to="/editorial"
          className="inline-flex items-center justify-center px-4 py-2 bg-primary-700 text-white font-medium rounded-md hover:bg-primary-800 transition-colors"
        >
          Return to Editorial Board
        </Link>
      </div>
    );
  }

  return (
    <div className="max-w-6xl mx-auto">
      <Link 
        to="/editorial" 
        className="inline-flex items-center text-sm text-gray-600 hover:text-primary-700 mb-6 transition-colors"
      >
        ← Back to Editorial Board
      </Link>

      {/* Profile Header */}
      <div className="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div className="p-6 md:p-8">
          <div className="flex flex-col md:flex-row items-center md:items-start gap-6">
            {members.image ? (
              <img 
                src={`${BASEURL}${members.image}`} 
                alt={members.name} 
                className=" object-cover" style={{width:'175px',height:'175px'}}
              />
            ) : (
              <div className="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center">
                <span className="text-gray-500 text-3xl font-medium">
                  {members.name}
                </span>
              </div>
            )}
            
            <div className="flex-1 text-center md:text-left">
              <h1 className="font-serif text-3xl font-bold text-gray-900 mb-2">
                {members.name}
              </h1>
              <p className="text-xl text-primary-700 mb-4">{members.jobs && members.jobs.name ? members.jobs.name : ""}</p>
              
              <div className="space-y-2 text-gray-600">
                <div className="flex items-center justify-center md:justify-start">
                  <GraduationCap className="h-5 w-5 mr-2" />
                  <span>{members.universities && members.universities.name ? members.universities.name: ''}</span>
                </div>
                
                <div className="flex items-center justify-center md:justify-start">
                  <MapPin className="h-5 w-5 mr-2" />
                  <span>{members.locations && members.locations.name? members.locations.name:''}</span>
                </div>
                
                <div className="flex items-center justify-center md:justify-start">
                  <Mail className="h-5 w-5 mr-2" />
                  <a 
                    href={`mailto:${members.email}`} 
                    className="text-primary-700 hover:text-primary-800 transition-colors"
                  >
                    {members.email}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        className="about-content text-gray-600"
        dangerouslySetInnerHTML={{ __html: members.about }}
      />

      
    </div>
  );
};

export default EditorialMemberPage;