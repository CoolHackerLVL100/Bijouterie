import React, {Component} from "react"
import Navbar from "./Navbar"
import '../css/Profile.css'
import getCookie from "./Cookies"

class UserInfo extends Component {
    constructor(props){
        super(props)

        this.state = {
            data: null
        }
    }

    componentDidMount(){
        fetch('http://localhost/Bijouterie/backend/api/user/' + getCookie('id') + '/', {
            method: 'GET',
            credentials: 'include',
            headers: {
                Authorization: getCookie('jwt')
            }
        })

        .then(res => res.json())
        .then(
            (result) => {
                this.setState({
                    is_loaded: true,
                    data: result.data,
                    
                })                
            },
            (error) => {
                this.setState({
                    is_loaded: true,
                    error
                })
            }
        )        
    }


    render(){
        return (
            <div className="user_info PlayfairDisplay">
                <div className="avatar">

                </div>
                <div>
                    <div className="firstname">Имя: {this.state.data?.firstname}</div>
                    <div className="lastname">Фамилия: {this.state.data?.lastname}</div>
                    <div className="gender">Пол: {this.state.data?.gender}</div>
                    <div className="email">Почта: {this.state.data?.email}</div>
                    <div className="reg_date">Дата регистрации: {this.state.data?.registration_date}</div>
                    <div className="stock">Персональная скидка: {this.state.data?.personal_stock}</div>
                    
                </div>
                
            </div>
        )
    }
}

export default UserInfo

