import { Component } from "react";
import { createRoot } from "react-dom/client";
import React from "react";
import { HashRouter,Routes,Route } from "react-router-dom";
import Create from "./pages/create";
import Login from "./pages/login";
class App extends Component{
    render(){
        return <HashRouter>
                    <Routes>
                        <Route path="/" element={<Login/>} />
                        <Route path="/create" element={<Create/>} />
                    </Routes>
                </HashRouter>
    }
}
const root = createRoot(document.getElementById('app'));
root.render(<App/>);