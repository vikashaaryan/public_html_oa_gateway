import React, { useEffect, useState } from 'react';
import Navbar from './Navbar';
import Footer from './Footer';
import { useLocation } from 'react-router-dom';

interface LayoutProps {
  children: React.ReactNode;
}

const Layout: React.FC<LayoutProps> = ({ children }) => {
  const [loading,setLoading] = useState(false);
  const location = useLocation();
  useEffect(()=>{
    setLoading(true);
    const timeout = setTimeout(() => {
      setLoading(false);
    }, 500); // adjust for real loading behavior

    return () => clearTimeout(timeout);
  }, [location.pathname])
  if (loading) {
    return (
      <div className="h-screen flex items-center justify-center bg-gray-900 text-white">
        <div className="animate-spin h-10 w-10 border-4 border-white border-t-transparent rounded-full"></div>
      </div>
    );
  }
  return (
    <div className="min-h-screen flex flex-col bg-gray-50">
      
      <Navbar />
      <main className="flex-grow container mx-auto px-4 py-8 md:py-12 max-w-7xl">
        {children}
      </main>
      <Footer />
    </div>
  );
};

export default Layout;