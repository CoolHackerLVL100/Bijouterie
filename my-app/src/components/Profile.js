import React, {Component} from "react"
import Navbar from "./Navbar"
import Tabs from "./Tabs"
import UserInfo from "./UserInfo"
import Cart from "./Cart"
import getCookie from "./Cookies"

class Profile extends Component {
    constructor(props){
        super(props)

        this.state = {
            tab: 'Профиль',
        }

        this.handleSubmit = this.handleSubmit.bind(this)
        this.renderPage = this.renderPage.bind(this)
    }

    handleSubmit(state){
        this.setState(state)
    }

    componentDidMount() {
        if (!getCookie('id'))
            window.location = 'http://localhost:3000/auth'

    }

    renderPage(tab){
        switch (tab){
            case 'Корзина':
                return <Cart />
            case 'Отзывы':
                return <UserInfo />
            case 'Профиль':
                return <UserInfo />
            case 'Заказы':
                return <UserInfo />
            case 'Выйти':
                document.cookie='jwt=; max-age=0'
                document.cookie='id=; max-age=0'
                window.location = 'http://localhost:3000/auth'
        }
    }

    render(){
        return (
            <div>
                <Navbar/>   
                <div className="user_section">
                    <div className="container">
                        <div className="user_content">
                            <Tabs tab={this.state.tab} onSubmit={this.handleSubmit}/>
                            {this.renderPage(this.state.tab)}
                        </div>
                    </div>
                </div>              
            </div>    
        )
    }
}

export default Profile

