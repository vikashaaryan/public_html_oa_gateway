import React, { useEffect, useState } from 'react';
import EditorialMemberCard from '../components/EditorialMemberCard';
import { editorialMembers } from '../data/mockData';
import axios from 'axios';
import { BASEURL } from '../App';
const EditorialPage: React.FC = () => {
  const [setting,setSetting] = useState({});
  const loadSetting = ()=>{
        axios.get(BASEURL+'front_setting').then((response)=>{
            setSetting(response.data.data);
        })
      }
  // Group editorial members by role
  const [jobs,setJobs] = useState([]);
  const [editorChief,setEditorChief] = useState([]);
  const loadAuthors = () =>{
    axios.get(BASEURL+'front_authors').then(response => response.data).then((response_data)=>{
      let jobs = response_data.data;
      setJobs(jobs);
    })
  }
  const loadEditorsChief = () =>{
    axios.get(BASEURL+'front_editors').then(response => response.data).then((response_data)=>{
      let editorChief = response_data.data;
      setEditorChief(editorChief);
    })
  }
  useEffect(()=>{
    loadAuthors();
    loadSetting();
    loadEditorsChief();
  },[])
  return (
    <div className='max-w-6xl mx-auto'>
      <section className="mb-12">
        <h1 className="font-serif text-3xl md:text-4xl font-bold text-gray-900 mb-4">
          Editorial Board
        </h1>
        <p className="text-lg text-gray-600 max-w-full">
          {setting.editorial_board}
        </p>
      </section>
      {/* Editor-in-Chief Section */}
      {/* <section className="mb-12">
        <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Editor-in-Chief
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
          {editorChief.map((editor,index) => (
            <EditorialMemberCard key={index} member={editor} />
          ))}
        </div>
      </section> */}

      {/* Associate Editors Section */}
      <section>
        {jobs.map((job1,index1)=>(
          <div key={index1}>
            <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
              {job1.name}
            </h2>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-4">
              {job1?.authors?.length ? (
                  job1.authors.map((member,index2) => (
                     member.status === 'active' ? (
                    <EditorialMemberCard key={index2} member={member} />
                     ):''
                  ))
                ) : (
                  ''
                )}
            </div>
          </div>
        ))}
      </section>

      {/* Editorial Board Information */}
      <section className="mt-16 bg-gray-50 rounded-lg p-6 md:p-8">
        <h2 className="font-serif text-xl font-semibold text-gray-900 mb-4">
          About Our Editorial Process
        </h2>
        <div className="text-gray-600 space-y-4">
          <p dangerouslySetInnerHTML={{ __html: setting.editorial_process }}>
          </p>
        </div>
      </section>
    </div>
  );
};

export default EditorialPage;