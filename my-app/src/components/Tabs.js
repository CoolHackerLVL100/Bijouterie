import React, {Component} from "react"
import '../css/Common.css'

class Filter extends Component {
    constructor(props){
        super(props)
        this.state = {
            tab: this.props.tab
        }

        this.tabs = ['Корзина', 'Отзывы', 'Профиль', 'Заказы', 'Выйти']

        this.handleClick = this.handleClick.bind(this)
    }    

    handleClick(event){           
        this.setState({
            tab: this.tabs.find((element) => element == event.target.name)
        }, () => this.props.onSubmit(this.state))
            
        event.preventDefault()
    }

    render(){
        return (
            <div className="tabs">
                <form className="PlayfairDisplay" onSubmit={this.handleSubmit}>
                    {this.tabs.map(tab => tab == this.state.tab ? (
                        <button className="selected_type PlayfairDisplay" disabled key={tab} type="submit" name={tab}>{tab}</button>
                    ) : (
                        <button className="PlayfairDisplay" key={tab} type="submit" name={tab} onClick={this.handleClick}>{tab}</button>
                    ))}
                    
                </form>
            </div>
        )
    }
}

export default Filter