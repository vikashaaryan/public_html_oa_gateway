import React, { useState,useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { Menu, X, BookOpen, Search } from 'lucide-react';
import axios from 'axios';
import { BASEURL } from '../App';

const Navbar = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [setting,setSetting] = useState([]);
  const location = useLocation();

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen);
  };
  const loadsetting = () =>{
    axios.get(BASEURL+'front_setting').then(response=>response.data).then(response_data=>{
      let setting = response_data.data;
      setSetting(setting);
    })
  }
  useEffect(() => {
    loadsetting();
  }, [])
  

  const navLinks = [
    { name: 'Home', path: '/' },
     { name: 'Articles', path: '/articlespage' },
    { name: 'Gateways', path: '/gateways' },
    { name: 'Editorial Board', path: '/editorial' },
    { name: 'Submit Article', path: '/submit' },
    { name: 'Search', path: '/search' }
  ];

  const isActive = (path: string) => {
    return location.pathname === path;
  };

  return (
    <header className="bg-white shadow-sm sticky top-0 z-50">
      <div className="container mx-auto px-4 max-w-7xl">
        <div className="flex justify-between items-center py-4">
          <Link 
            to="/" 
            className="flex items-center space-x-2 text-primary-900 transition-all duration-200 hover:text-primary-700"
          >
            {setting.logo ? (
              <img  src={`${BASEURL}${setting.logo}`} alt={setting.title} className="h-16 w-16 rounded-full object-cover mr-4"/>
            ) :''}
            <div className="flex flex-col">
              <span className="font-serif text-xl font-bold tracking-tight">{setting.title}</span>
            </div>
          </Link>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex space-x-8">
            {navLinks.map((link) => (
              <Link
                key={link.name}
                to={link.path}
                className={`text-sm font-medium transition-all duration-200 hover:text-primary-700 ${
                  isActive(link.path) 
                    ? 'text-primary-800 border-b-2 border-primary-800' 
                    : 'text-gray-600'
                }`}
              >
                {link.name}
              </Link>
            ))}
          </nav>

          {/* Mobile Menu Button */}
          <button 
            onClick={toggleMenu} 
            className="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none"
            aria-label="Toggle menu"
          >
            {isMenuOpen ? <X /> : <Menu />}
          </button>
        </div>

        {/* Mobile Navigation */}
        <div className={`md:hidden ${isMenuOpen ? 'block' : 'hidden'}`}>
          <nav className="flex flex-col space-y-3 pb-4">
            {navLinks.map((link) => (
              <Link
                key={link.name}
                to={link.path}
                className={`text-sm font-medium py-2 transition-all duration-200 ${
                  isActive(link.path) 
                    ? 'text-primary-800 font-semibold' 
                    : 'text-gray-600 hover:text-primary-700'
                }`}
                onClick={() => setIsMenuOpen(false)}
              >
                {link.name}
              </Link>
            ))}
          </nav>
        </div>
      </div>
    </header>
  );
};

export default Navbar