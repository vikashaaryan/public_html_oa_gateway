import React, { useEffect,useRef, useState } from 'react';
import { Link, Navigate, useLocation, useNavigate } from 'react-router-dom';
import { FileText, CheckCircle, Clock, Users, AlertCircle } from 'lucide-react';
import axios from 'axios';
import { BASEURL } from '../App';

const SubmissionPage = () => {
  const [subjects, setSubjects] = useState([]);
  const [setting, setSetting] = useState({});
  const [errors, setErrors] = useState([]);
    const [successMessage,setSucessMessage] = useState([]);

  const [inputs, setInputs] = useState({
    first_name: '',
    last_name: '',
    email: '',
    institution: '',
    manuscript_title: '',
    article_type:'',
    article_topic:'',
    subject: '',
    abstract: '',
    document: '',
    comments: '',
    confirm: false,
    agree: false
  });
  const loadSetting = () => {
    axios
      .get(BASEURL + 'front_setting')
      .then((response) => {
        setSetting(response.data.data);
      })
      .catch((err) => console.error('Error loading settings:', err));
  };

  const navigate = useNavigate();
  const location = useLocation();
  const successMessageRef = useRef(); 
  const errorRefs = useRef({});
  const [faqs,setFAQ] = useState([]);
  const loadFAQ = () =>{
    axios.get(BASEURL+'front_faq').then(response =>response.data).then(response_data =>{
        let faqs = response_data.data;
        setFAQ(faqs);
    })
  }
  // Load subjects on component mount
  useEffect(() => {
    loadSetting();
    axios.get('front_subjects')
      .then(response => response.data)
      .then(data => setSubjects(data.data))
      .catch(error => console.error("Error loading subjects", error));
      loadFAQ();
  }, []);

  // Handle input changes
  const handleChange = (e) => {
    const { name, type, value, checked, files } = e.target;

    if (type === 'checkbox') {
      setInputs((prev) => ({ ...prev, [name]: checked }));
    } else if (type === 'file') {
      setInputs((prev) => ({ ...prev, [name]: files[0] }));
    } else {
      setInputs((prev) => ({ ...prev, [name]: value }));
    }
  };

  // Handle form submission
  const handleSubmit = (e) => {
    e.preventDefault(); // Prevent form submission to avoid page refresh

    const formData = new FormData();
    formData.append("first_name", inputs.first_name);
    formData.append("last_name", inputs.last_name);
    formData.append("email", inputs.email);
    formData.append("institution", inputs.institution);
    formData.append("manuscript_title", inputs.manuscript_title);
    formData.append("article_type", inputs.article_type);
    formData.append("article_topic", inputs.article_topic);
    formData.append("subject", inputs.subject);
    formData.append("abstract", inputs.abstract);
    formData.append("comments", inputs.comments);
    formData.append("confirm", inputs.confirm ? 1 : '');
    formData.append("agree", inputs.agree ? 1 : '');
    if (inputs.document) formData.append("document", inputs.document);

    axios.post('front_submit_article', formData, {
      headers: { "Content-Type": "multipart/form-data" }
    })
      .then(response => {
        if (response.data.success === 0) {
          setErrors(response.data.errors);
          const firstErrorField = Object.keys(response.data.errors)[0];
          if (errorRefs.current[firstErrorField]) {
            errorRefs.current[firstErrorField].scrollIntoView({ behavior: 'smooth' });
          }
        } else {
           setErrors([]);
          // Success: Navigate to the submit page with a success message
          setInputs({
            first_name: '',
            last_name: '',
            email: '',
            institution: '',
            manuscript_title: '',
            article_type: '',
            article_topic: '',
            subject: '',
            abstract: '',
            document: '',
            comments: '',
            confirm: '',
            agree: '',
          });
          setSucessMessage('Form Submitted Successfully! Please Wait for Approval');
          // Scroll to the success message
          successMessageRef.current?.scrollIntoView({ behavior: 'smooth' });
          setTimeout(() => {
            setSucessMessage('');
          }, 5000); 
        }
      })
      .catch(error => console.error("Error submitting form:", error));
  };

  return (
    <div className="max-w-6xl mx-auto">
      
      <h1 className="font-serif text-3xl md:text-4xl font-bold text-gray-900 mb-4">
        Article Submission
      </h1>
      <p className="text-lg text-gray-600 mb-8">
        Thank you for your interest in submitting your research to the International Journal of Advanced Research.
        Please review our submission guidelines before proceeding.
      </p>

      {/* Submission Process */}
      <section className="mb-12">
        <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Submission Process
        </h2>
        
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <div className="flex items-start mb-4">
              <div className="bg-primary-100 p-2 rounded-full mr-4">
                <FileText className="h-6 w-6 text-primary-700" />
              </div>
              <div>
                <h3 className="font-serif text-lg font-semibold text-gray-900 mb-2">
                  Prepare Your Manuscript
                </h3>
                <p className="text-gray-600 text-sm">
                  Format your manuscript according to our guidelines. Include all necessary sections, 
                  figures, and references in the appropriate style.
                </p>
              </div>
            </div>
          </div>
          
          <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <div className="flex items-start mb-4">
              <div className="bg-primary-100 p-2 rounded-full mr-4">
                <Users className="h-6 w-6 text-primary-700" />
              </div>
              <div>
                <h3 className="font-serif text-lg font-semibold text-gray-900 mb-2">
                  Peer Review
                </h3>
                <p className="text-gray-600 text-sm">
                  Your manuscript will undergo rigorous peer review by at least two independent experts 
                  in your field of research.
                </p>
              </div>
            </div>
          </div>
          
          <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <div className="flex items-start mb-4">
              <div className="bg-primary-100 p-2 rounded-full mr-4">
                <Clock className="h-6 w-6 text-primary-700" />
              </div>
              <div>
                <h3 className="font-serif text-lg font-semibold text-gray-900 mb-2">
                  Review Timeline
                </h3>
                <p className="text-gray-600 text-sm">
                  Initial screening: 1-2 weeks<br />
                  Peer review: 4-6 weeks<br />
                  Revision (if required): 2-4 weeks<br />
                  Final decision: 1-2 weeks
                </p>
              </div>
            </div>
          </div>
          
          <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <div className="flex items-start mb-4">
              <div className="bg-primary-100 p-2 rounded-full mr-4">
                <CheckCircle className="h-6 w-6 text-primary-700" />
              </div>
              <div>
                <h3 className="font-serif text-lg font-semibold text-gray-900 mb-2">
                  Publication
                </h3>
                <p className="text-gray-600 text-sm">
                  Upon acceptance, your article will be prepared for publication. You will receive 
                  proofs for final review before online publication.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Submission Guidelines */}
      <span  dangerouslySetInnerHTML={{ __html: setting.submit_article_text }}></span>

      {/* Submission Form */}
      <section className="mb-12" >
        <div className="max-w-xl mx-auto mt-10" >
        {successMessage!=''? (
          <div className="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <strong>Success!</strong> {successMessage}
          </div>
        ):''}
      </div>
        <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200" ref={(el) => (errorRefs.current.first_name = el)}>
          Submit Your Manuscript
        </h2>
        <div ref={(el) => (errorRefs.current.last_name = el)} ></div>
        <div ref={(el) => (errorRefs.current.last_name = el)} ></div>
        <div ref={(el) => (errorRefs.current.email = el)} ></div>
        <div  ref={(el) => (errorRefs.current.institution = el)}></div>
        <div  ref={(el) => (errorRefs.current.manuscript_title = el)}></div>
        <div  ref={(el) => (errorRefs.current.subject = el)}></div>
        <div  ref={(el) => (errorRefs.current.abstract = el)}></div>
        <div  ref={(el) => (errorRefs.current.document = el)} ></div>
        <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-6 md:p-8">
          <form onSubmit={handleSubmit}>
            <div className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    First Name*
                  </label>
                  <input name="first_name"
                    type="text"
                    className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange}
                  value={inputs.first_name}/>
                  {errors.first_name?(<p ref={(el) => (errorRefs.current.email = el)} className="block text-red-800">{errors.first_name}</p>):''}
                </div>
                
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Last Name*
                  </label>
                  <input name="last_name" 
                    type="text"
                    className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange} value={inputs.last_name}
                  />
                  {errors.last_name?(<p className="block text-red-800">{errors.last_name}</p>):''}
                </div>
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Email Address*
                </label>
                <input name="email" 
                  type="text"
                  className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange} value={inputs.email}
                />
                  {errors.email?(<p  className="block text-red-800">{errors.email}</p>):''}
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Institution/Affiliation*
                </label>
                <input name="institution" 
                  type="text"
                  className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange} value={inputs.institution}
                />
                {errors.institution?(<p  className="block text-red-800">{errors.institution}</p>):''}

              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Manuscript Title*
                </label>
                <input name="manuscript_title" 
                  type="text"
                  className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange} value={inputs.manuscript_title}
                />
                {errors.manuscript_title?(<p  className="block text-red-800">{errors.manuscript_title}</p>):''}
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Article Type
                </label>
                <input name="article_type" 
                  type="text"
                  className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange} value={inputs.article_type}
                />
                {errors.article_type?(<p  className="block text-red-800">{errors.article_type}</p>):''}
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Article Topic
                </label>
                <input name="article_topic" 
                  type="text"
                  className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange} value={inputs.article_topic}
                />
                {errors.article_topic?(<p  className="block text-red-800">{errors.article_topic}</p>):''}
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Subject Area*
                </label>
                <select value={inputs.subject} className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" name="subject" onChange={handleChange}>
                  <option value="">Select a subject area</option>
                  {subjects.map((subject)=>(
                  <option value={subject.id} key={subject.id}>{subject.name}</option>
                  ))}
                </select>
                {errors.subject?(<p  className="block text-red-800">{errors.subject}</p>):''}
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Abstract*
                </label>
                <textarea name="abstract"
                  rows={4}
                  className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange} value={inputs.abstract}
                ></textarea>
                <p className="text-xs text-gray-500 mt-1">Maximum 250 words</p>
                {errors.abstract?(<p ref={(el) => (errorRefs.current.confirm = el)}   className="block text-red-800">{errors.abstract}</p>):''}

              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Upload Manuscript (DOC,DOCX or PDF)*
                </label>
                <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                  <div className="space-y-1 text-center">
                    <FileText className="mx-auto h-12 w-12 text-gray-400" />
                    <div className="flex text-sm text-gray-600">
                      <label className="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                        <span>Upload a file</span>
                        <input type="file" name="document" className="sr-only" onChange={handleChange} />
                      </label>
                      <p className="pl-1">or drag and drop</p>
                    </div>
                    <p className="text-xs text-gray-500">
                      PDF, DOC, DOCX up to 10MB
                    </p>
                    {errors.document?(<p  ref={(el) => (errorRefs.current.agree = el)}   className="block text-red-800">{errors.document}</p>):''}
                  </div>
                </div>
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Comments to Editor (Optional)
                </label>
                <textarea name="comments" value={inputs.comments}
                  rows={3}
                  className="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" onChange={handleChange}
                ></textarea>
                {errors.comments?(<p ref={(el) => (errorRefs.current.comments = el)} className="block text-red-800">{errors.comments}</p>):''}
              </div>
              
              <div className="flex items-start">
                <div className="flex items-center h-5">
                  <input onChange={handleChange} 
                    type="checkbox" name="confirm" value={inputs.confirm}
                    className="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                  />
                </div>
                <div className="ml-3 text-sm">
                  <label className="text-gray-600">
                    I confirm that this manuscript has not been published elsewhere and is not under consideration by another journal.
                  </label>
                  {errors.confirm?(<p className="block text-red-800">{errors.confirm}</p>):''}

                </div>
              </div>
              
              <div className="flex items-start">
                <div className="flex items-center h-5">
                  <input onChange={handleChange} name="agree"
                    type="checkbox"
                    className="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" value={inputs.confirm}
                  />

                </div>
                <div className="ml-3 text-sm">
                  <label className="text-gray-600">
                    I agree to the journal's publication terms and policies.
                  </label>
                  {errors.agree?(<p className="block text-red-800">{errors.agree}</p>):''}

                </div>
              </div>
              
              <div className="flex flex-col md:flex-row gap-4 justify-end">

                {/* <button
                  type="submit"
                  className="px-6 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                  Save Draft
                </button> */}
                <button
                  type="submit"
                  className="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-700 hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                  Submit Manuscript
                </button>
              </div>
            </div>
          </form>
        </div>
      </section>

      {/* FAQ Section */}
      <section>
        <h2 className="font-serif text-2xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
          Frequently Asked Questions
        </h2>
        
        <div className="bg-gray-50 rounded-lg p-6 md:p-8 space-y-4">
          {faqs?.map((faq1) => (
          <details className="group">
            <summary className="flex justify-between cursor-pointer font-medium text-gray-800">
              <span>{faq1.name}</span>
              <span className="transition group-open:rotate-180">+</span>
            </summary>
            <p className="text-gray-600 mt-2 pl-4 text-sm">
              {faq1.description}
            </p>
          </details>
          ))}
        </div>
      </section>
    </div>
  );
};

export default SubmissionPage;
