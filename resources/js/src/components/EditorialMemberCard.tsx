import React from 'react';
import { Link } from 'react-router-dom';
import { MapPin, GraduationCap } from 'lucide-react';
import { BASEURL } from '../App';

const EditorialMemberCard = ({ member }) => {
  return (
    <div className="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
      <div className="p-6 flex justify-between items-start gap-6">
        {/* Right side: Image */}
        <div className="flex-shrink-0">
          {member.image ? (
            <img
              src={`${BASEURL}${member.image}`}
              alt={member.name}
              className="w-[200px] h-[200px] object-cover rounded-lg"
            />
          ) : (
            <div className="w-[200px] h-[200px] rounded-lg bg-gray-200 flex items-center justify-center">
              <span className="text-gray-500 text-4xl font-medium">
                {member.name.charAt(0)}
              </span>
            </div>
          )}
        </div>
        {/* Left side: Textual Content */}
        <div className="flex-1">
          <div className="mb-4">
            <Link to={`/editorial/${member.slug_url}`}>
              <h3 className="font-serif text-xl font-semibold text-gray-900 hover:text-primary-700 transition-colors">
                {member.name}
              </h3>
            </Link>
            <p className="text-sm text-gray-600">{member.jobs.name}</p>
          </div>

          <div className="flex items-center text-sm text-gray-500 mb-2">
            <GraduationCap className="h-4 w-4 mr-1" />
            <span>{member.universities.name}</span>
          </div>

          <div className="flex items-center text-sm text-gray-500 mb-4">
            <MapPin className="h-4 w-4 mr-1" />
            <span>{member.locations.name}</span>
          </div>

          <Link
            to={`/editorial/${member.slug_url}`}
            className="text-sm font-medium text-primary-700 hover:text-primary-800 transition-colors"
          >
            View profile →
          </Link>
        </div>

        
      </div>
    </div>
  );
};

export default EditorialMemberCard;
