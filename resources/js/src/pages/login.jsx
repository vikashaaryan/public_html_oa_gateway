import React , { useEffect, useState } from "react";
import '../../../css/bootstrap.min.css'; 
import  '../../../style.css';
import axios from "axios";
import bgimg from '../../../img/bg-img/bg-3.jpg'
const useScript = (src) => {
    useEffect(() => {
      const script = document.createElement('script');
      script.src = src;
      script.async = true;
      document.body.appendChild(script);
  
      return () => {
        document.body.removeChild(script);
      };
    }, [src]);
};
const handleChange = (event)=>{
    setInputs({...inputs,[event.target.name]:event.target.value});
}
const Login = () => {
    const [inputs,setInputs] = useState({name:'',password:''});
    useEffect(() => {
        // Code from script.js will be executed once the component is mounted
        console.log("Login Page Loaded");
    }, []);
    const handleSubmit = (e) => {
        e.preventDefault(); // Prevent form submission to avoid page refresh
        // You can handle form submission logic here (e.g., validation, API call)
        let data = {name:inputs.name,password:inputs.password}
    };

    return (
        <div>
            <div id="preloader" className="d-none">
                <div className="item">
                    <i className="loader --8"></i>
                </div>
            </div>

            <div className="main-content- h-100vh bg-img" style={{ backgroundImage:`url(${bgimg})`}}>
                <div className="container h-100">
                    <div className="row h-100 align-items-center justify-content-center">
                        <div className="col-sm-10 col-md-7 col-lg-5">
                            <div className="middle-box">
                                <div className="card">
                                    <div className="card-body p-4 py-5">
                                        <div className="log-header-area mb-5 text-center">
                                            <h5>Welcome Back!</h5>
                                            <p className="mb-0">Sign in to continue.</p>
                                        </div>

                                        <form onSubmit={handleSubmit}>
                                            <div className="form-group mb-3">
                                                <label className="text-muted" htmlFor="emailaddress">Email address</label>
                                                <input
                                                    className="form-control"
                                                    type="text"
                                                    id="emailaddress"
                                                    placeholder="Enter your email"
                                                    name="email" onChange={handleChange}
                                                />
                                            </div>

                                            <div className="form-group mb-4">
                                                <label className="text-muted" htmlFor="password">Password</label>
                                                <input
                                                    className="form-control"
                                                    type="password"
                                                    id="password"
                                                    placeholder="Enter your password"
                                                    name="password" onChange={handleChange}
                                                />
                                            </div>

                                            <div className="form-group mb-3">
                                                <button className="btn btn-primary btn-lg w-100" type="submit">
                                                    Sign In
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Login;
