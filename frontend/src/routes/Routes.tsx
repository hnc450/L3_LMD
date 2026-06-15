
import { Route, Routes as Routing } from "react-router-dom";
import Auth from "../pages/Auth";
import Home from "../pages/Home";
import Otp from "../components/Otp";
import Account from "../pages/Account";
import ForgetPassword from "../pages/ForgetPassword";
import Products from "../pages/Products";

export default function Routes(){
    return (
        <Routing>
            <Route path="/" element={<Home />} />
            <Route path="/login" element={<Auth />} />
            <Route path="/otp" element={<Otp />} />
            <Route path="/register" element={<Account />} />
            <Route path="/forget-password" element={<ForgetPassword />} />
            <Route path="/products" element={<Products />} />
        </Routing>
    )
}