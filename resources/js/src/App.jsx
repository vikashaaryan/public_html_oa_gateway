import { Component } from "react";
import { createRoot } from "react-dom/client";
import React from "react";
import { HashRouter,Routes,Route } from "react-router-dom";
import Layout from './components/Layout';
import ArchivePage from './pages/ArchivePage';
import ArticlePage from './pages/ArticlePage';
import ArticlesListPage from './pages/ArticlesListPage';

import HomePage from './pages/HomePage';
import EditorialMemberPage from './pages/EditorialMemberPage';
import EditorialPage from './pages/EditorialPage';
import GatewayPage from './pages/GatewayPage';
import GatewayUniversityPage from './pages/GatewayUniversityPage';
import GatewayTopicPage from './pages/GatewayTopicPage';
import IssuePage from './pages/IssuePage';
import SearchArticlePage from './pages/SearchArticlePage';
import SearchPage from './pages/SearchPage';
import SubjectPage from './pages/SubjectPage';
import SubmissionPage from './pages/SubmissionPage';
import UniversityPage from './pages/UniversityPage';
import TopicPage from './pages/TopicPage';

import ScrollToTop from "./components/ScrollTop";
import StaticPage from './pages/StaticPage';

import '@fontsource/inter'; // Defaults to weight 400
import '@fontsource/merriweather';

export const BASEURL = 'https://oagateway.com/';

class App extends Component{
    render(){
        return <HashRouter>
            <ScrollToTop/>
             <Layout>
                    <Routes>
                        <Route path="/" element={<HomePage />} />
                        <Route path="/archive" element={<ArchivePage />} />
                        <Route path="/archive/:volumeId/:issueId" element={<IssuePage />} />
                        <Route path="/article/:id" element={<ArticlePage />} />
                        <Route path="/articlespage" element={<ArticlesListPage />} />

                        <Route path="/editorial" element={<EditorialPage />} />
                        <Route path="/editorial/:id" element={<EditorialMemberPage />} />
                        <Route path="/gateways" element={<GatewayPage />} />
                        <Route path="/gatewaystopic" element={<GatewayTopicPage />} />
                        <Route path="/gatewaysuniversity" element={<GatewayUniversityPage />} />
                        <Route path="/search" element={<SearchPage />} />
                        <Route path="/searcharticle" element={<SearchArticlePage />} />
                        <Route path="/subject/:id" element={<SubjectPage />} />

                        <Route path="/submit" element={<SubmissionPage />} />
                        <Route path="/topic/:id" element={<TopicPage />} />
                        <Route path="/university/:id" element={<UniversityPage />} />
                        <Route path="/:slug" element={<StaticPage />} />
                    </Routes>
                    </Layout>
                </HashRouter>
    }
}
const root = createRoot(document.getElementById('app'));
root.render(<App/>);