
import { Route, Routes as Routing } from "react-router-dom";
import Auth from "../pages/Auth";
import Home from "../pages/Home";
import Otp from "../components/Otp";
import Account from "../pages/Account";
import ForgetPassword from "../pages/ForgetPassword";
import Products from "../pages/Products";
import User from "../pages/User";
import Favorites from "../pages/Favorites";
import Admin from "../pages/admin/Admin";
import Seller from "../pages/seller/Seller";

export default function Routes(){
    return (
        <Routing>
            <Route path="/" element={<Home />} />
            <Route path="/login" element={<Auth />} />
            <Route path="/otp" element={<Otp />} />
            <Route path="/register" element={<Account />} />
            <Route path="/forget-password" element={<ForgetPassword />} />
            <Route path="/products" element={<Products />} />
            <Route path="/user" element={<User/>}/>
            <Route path="/user/favorites" element={<Favorites/>}/>
            <Route path="/admin" element={<Admin/>}/>
            <Route path="/seller" element={<Seller/>}/>
        </Routing>
    )
}