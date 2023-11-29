import React, {Component} from "react"
import '../css/Common.css'

class Types extends Component {
    constructor(props){
        super(props)
        this.state = {
            type: this.props.type
        }

        this.type_values = [['Кольца', 'Кольцо'], ['Браслеты', 'Браслет'], ['Подвески', 'Подвеска'], ['Любые', ''], ['Цепочки', 'Цепь'], ['Броши', 'Брошь'], ['Серьги', 'Серьги']]

        this.handleClick = this.handleClick.bind(this)
    }    

    handleClick(event){
        this.setState({
            type: this.type_values.find((element) => element[0] == event.target.name)[1]
        }, () => this.props.onSubmit(this.state))
            
        event.preventDefault()
    }

    render(){
        return (
            <div className="types">
                <form className="PlayfairDisplay">
                    {this.type_values.map(type => type[1] == this.state.type ? (
                        <button className="selected_type PlayfairDisplay" disabled key={type[0]} type="submit" name={type[0]}>{type[0]}</button>
                    ) : (
                        <button className="PlayfairDisplay" key={type[0]} type="submit" name={type[0]} onClick={this.handleClick}>{type[0]}</button>
                    ))}
                    
                </form>
            </div>
        )
    }
}

export default Types