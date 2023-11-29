import React, {Component} from "react"
import '../css/Common.css'

class Filter extends Component {
    constructor(props){
        super(props)
        this.state = {
            min_price: this.props.min_price,
            max_price: this.props.max_price,
            gender: this.props.gender,
            size: this.props.size,
            stones: this.props.stones,
            materials: this.props.materials
        }

        this.size_values = [15, 15.5, 16, 16.5, 17, 17.5, 18, 18.5, 19, 19.5, 20, 20.5, 21, 22, 23, 50, 55, 60]
        this.stone_values = ['Фианит', 'Ювелирное стекло', 'Эмаль', 'Кварц', 'Янтарь', 'Султанит', 'Перламутр', 'Гематит', 'Жемчуг', 'Агат', 'Шпинель', 'Халцедон', 'Корунд', 'Опал', 'Кристалл', 'Авантюрин']
        this.material_values = ['Золото', 'Серебро', 'Медсплав', 'Керамика', 'Нержавеющая сталь', 'Родирование', 'Бижутерный сплав']

        this.handleChange = this.handleChange.bind(this)
        this.handleSubmit = this.handleSubmit.bind(this)
    }    

    handleChange(event){
        if (event.target.classList.contains('multiple_choice')){
            let arr = Array.from(this.state[event.target.name])

            if (event.target.checked){
                arr.push(event.target.value)            
            } else {
                arr = arr.filter(item => item != event.target.value)
            }
            this.setState({
                [event.target.name]: arr
            })              
        } else {
            this.setState({
                [event.target.name]: event.target.value 
            })
        }
    }

    handleSubmit(event){
        this.props.onSubmit(this.state)
        event.preventDefault()
    }

    render(){
        return (
            <aside>
                <form className="PlayfairDisplay" onSubmit={this.handleSubmit}>
                    <div className="price_selector selector">
                        <p className="selector_title">Цена</p>
                        <label>
                            Минимальная цена: {this.state.min_price}
                            <input name="min_price" type="range" min={5} max={100} value={this.state.min_price} onChange={this.handleChange}/>
                        </label>
                        <label>
                            Максимальная цена: {this.state.max_price}
                            <input name="max_price" type="range" min={5} max={100} value={this.state.max_price} onChange={this.handleChange}/>
                        </label>                                                   
                    </div>        
                    <div className="gender_selector selector">
                        <p className="selector_title">Пол</p>
                        <label>
                            <input type="radio" name="gender" value="m" onChange={this.handleChange}/>
                            Мужской
                        </label>
                        <label>
                            <input defaultChecked type="radio" name="gender" value="f" onChange={this.handleChange}/>
                            Женский
                        </label>                          
                        <label>
                            <input type="radio" name="gender" value="u" onChange={this.handleChange}/>
                            Любой
                        </label>       
                    </div>          
                    <div className="size_selector selector">
                        <p className="selector_title">Размер</p>
                        {this.size_values.map(size => (
                            <label key={size}>
                                <input type="checkbox" className="multiple_choice" name="size" value={size} onChange={this.handleChange}/>
                                {size}
                            </label>
                        ))}
                    </div>
                    <div className="stone_selector selector">
                        <p className="selector_title">Вставка</p>
                        {this.stone_values.map(stone => (
                            <label key={stone}>
                                <input type="checkbox" className="multiple_choice" name="stones" value={stone} onChange={this.handleChange}/>
                                {stone}
                            </label>
                        ))}
                    </div>  
                    <div className="material_selector selector">
                        <p className="selector_title">Покрытие</p>
                        {this.material_values.map(material => (
                            <label key={material}>
                                <input type="checkbox" className="multiple_choice" name="materials" value={material} onChange={this.handleChange}/>
                                {material}
                            </label>
                        ))}
                    </div>
                    <button type="submit" className="PlayfairDisplay">Применить фильтр</button>
                </form>

            </aside>
        )
    }
}

export default Filter