import React, {Component} from "react"
import '../css/Form.css'

class Auth extends Component {
    constructor(props){
        super(props)
        this.state = {
            error: 'ㅤ'
        }

        this.handleSubmit =this.handleSubmit.bind(this)
    }

    handleSubmit(event){
        fetch("http://localhost/Bijouterie/backend/api/user/auth/", {
            method: "POST",
            credentials: 'include',
            body: new FormData(event.target)
        })
        .then(res => res.json())
        .then(
            (result) => {     
                if (result.status == 'Ok'){
                    window.location = 'http://localhost:3000/'
                }
                else {
                    this.setState({
                        error: result.message
                    })         
                    console.log(this.state)
                }
            },
            (error) => {
                this.setState({
                    error
                })
            }
        )
     
        event.preventDefault()
    }
    
    render(){
        return (
            <div className="auth_form">
                <form onSubmit={this.handleSubmit}>
                    <div className="field PlayfairDisplay">
                        <label>
                            Логин
                            <input type="text" name="login" />
                        </label>                        
                    </div>
                    <div className="field PlayfairDisplay">
                        <label>
                            Пароль
                            <input type="password" name="password" />
                        </label>                        
                    </div>

                    <p className="error_message PlayfairDisplay">
                        {this.state.error}
                    </p>

                    <button type="submit" className="PlayfairDisplay">Войти</button>

                    <a href='../reg' className="PlayfairDisplay">Зарегистрироваться</a>                       
                </form>  
            </div>
        )
    }
}

export default Auth

