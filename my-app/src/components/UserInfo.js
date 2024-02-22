import React, {Component} from "react"
import Navbar from "./Navbar"
import '../css/Profile.css'
import getCookie from "./Cookies"

class UserInfo extends Component {
    constructor(props){
        super(props)

        this.state = {
            firstname: null, 
            lastname: null,
            gender: null,
            email: null,
            registration_date: null,
            personal_stock: null,
            editable: false,
            isEdited: false
        }

        this.handleSubmit = this.handleSubmit.bind(this)
        this.handleChange = this.handleChange.bind(this)
    }

    setGender(gender){
        if (gender == 'f'){
            return 'Женский'
        } else if (gender == 'm') {
            return 'Мужской'
        } else {
            return 'Не определён'
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
                    firstname: result.data.firstname, 
                    lastname: result.data.lastname,
                    gender: result.data.gender,
                    email: result.data.email,
                    registration_date: result.data.registration_date,
                    personal_stock: result.data.personal_stock
   
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

    handleSubmit(event){
        if (this.state.editable){
            if (this.state.isEdited){
                fetch('http://localhost/Bijouterie/backend/api/user/' + getCookie('id') + '/', {
                    method: 'PATCH',
                    credentials: 'include',
                    headers: {
                        Authorization: getCookie('jwt')
                    },
                    body: JSON.stringify({
                        firstname: this.state.firstname,
                        lastname: this.state.lastname,
                        gender: this.state.gender,
                        email: this.state.email
                    })
                }).then(
                    (result) => {
                        this.setState({
                            isEdited: false
                        })
                    }
                )                
            }

        }

        this.setState({
            editable: !this.state.editable
        })
        event.preventDefault()
    }

    handleChange(event){
        this.setState({
            [event.target.name]: event.target.value,
            isEdited: true
        })
    }

    render(){
        return (
            <div className="user_info PlayfairDisplay">
                <div className="avatar">

                </div>
                
                {
                    !this.state.editable ? (  
                        <form className="user-fields" onSubmit={this.handleSubmit}>  
                            <div className="firstname">Имя: {this.state.firstname}</div>
                            <div className="lastname">Фамилия: {this.state.lastname}</div>
                            <div className="gender">Пол: {this.setGender(this.state.gender)}</div>
                            <div className="email">Почта: {this.state.email}</div>
                            <div className="reg_date">Дата регистрации: {this.state.registration_date}</div>
                            <div className="stock">Персональная скидка: {this.state.personal_stock}</div>
                            <button type="submit">Редактировать</button>
                        </form>
                    ) : (
                        <form className="user-fields" onSubmit={this.handleSubmit}>  
                            <label>
                                Имя: 
                                <input type="text" name="firstname" value={this.state.firstname} onChange={this.handleChange}/>
                            </label>
                            <label>
                                Фамилия: 
                                <input type="text" name="lastname" value={this.state.lastname} onChange={this.handleChange}/>
                            </label>
                            <label>
                                Пол: 
                                <select type="text" name="gender" value={this.state.gender} onChange={this.handleChange}>
                                    <option value="f">Женский</option>
                                    <option value="m">Мужской</option>
                                    <option value="u">Не определён</option>
                                </select> 
                            </label>
                            <label>
                                Почта: 
                                <input type="text" name="email" value={this.state.email} onChange={this.handleChange}/>
                            </label>          
                            <div className="reg_date">Дата регистрации: {this.state.registration_date}</div>
                            <div className="stock">Персональная скидка: {this.state.personal_stock}</div>
                            <button type="submit">Сохранить</button>
                        </form>    
                    ) 
                }

                
                
            </div>
                
            
        )
    }
}

export default UserInfo

