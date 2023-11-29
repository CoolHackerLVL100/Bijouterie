import React, {Component} from "react"
import  '../css/Navbar.css'
import '../css/Common.css'
import getCookie from "./Cookies"

class Navbar extends Component {
    constructor(props){
        super(props)
        this.state = {
            home: '',
            shop: '',
            gallery: '',
            basket: '',
            profile: '',
            leave: ''
        }

        this.site_name = "Perles Raffinées"

    
    }

    componentDidMount(){
        const icons = ['home', 'shop', 'gallery', 'basket', 'user', 'leave']
        icons.forEach((icon) => {
            fetch('http://localhost/Bijouterie/backend/api/image/icons/' + icon + '.svg')
            .then(res => res.text())
            .then(
                (result) => {
                    this.setState({
                        [icon]: result
                    })
                }, 
                (error) => {
                    console.log(error)
                }
            )
        })            
    }

    handleLeave(){
        document.cookie='jwt=; max-age=0'
        document.cookie='id=; max-age=0'
    }

    render(){
        return (
            <header>
                <div className="container">   
                    <div className="navigation_bar">
                        <div className="left_icons_group">
                            <a href="http://localhost:3000/">
                                <div className="icons" dangerouslySetInnerHTML={{__html: this.state.home}} />
                            </a>

                            <a href="http://localhost:3000/shop">
                                <div className="icons" dangerouslySetInnerHTML={{__html: this.state.shop}} />
                            </a>

                            <a href="http://localhost:3000/gallery">
                                <div className="icons" dangerouslySetInnerHTML={{__html: this.state.gallery}} />
                            </a>                               
                        </div>         

                        <div className="site_name PlayfairDisplay">
                            {this.site_name}
                        </div>

                        <div className="right_icons_group">
                            { 
                                getCookie('jwt') ? (
                                    <a href="http://localhost:3000/profile">
                                        <div className="icons" dangerouslySetInnerHTML={{__html: this.state.basket}} />               
                                    </a>
                                ) : (
                                    <a></a>
                                )
                            }
                            
                            { 
                                getCookie('jwt') ? (
                                    <a href="http://localhost:3000/profile">
                                        <div className="icons" dangerouslySetInnerHTML={{__html: this.state.user}} />               
                                    </a>
                                ) : (
                                    <a href="http://localhost:3000/auth">
                                        <div className="icons" dangerouslySetInnerHTML={{__html: this.state.user}} />               
                                    </a>
                                )
                            }

                            { 
                                getCookie('jwt') ? (
                                    <a href="http://localhost:3000/auth" onClick={this.handleLeave}>
                                        <div className="icons" dangerouslySetInnerHTML={{__html: this.state.leave}} />               
                                    </a>
                                ) : (
                                    <a></a>
                                )
                            }               
                        </div>                         
                    </div>
                </div>
            </header>
        )
    }
}

export default Navbar